<?php

namespace Sb\Phalcon\Service\Path;

use Phalcon\Di\Injectable;
use Sb\Phalcon\Exception\ApplicationException;

class GeoIp extends Injectable 
{
    private function getCurrentVersion()
    {
        $qb = $this->modelsManager->createBuilder()
            ->columns('MAX(version) as version')
            ->from('Entity\GeoIp');

        $rows = $qb->getQuery()->execute();
        return (int) $rows[0]['version'];
    }

    private function removeVersion($version)
    {
        $this->db->execute("DELETE FROM geo_ip WHERE version = :version", ['version' => $version]);
    }

    private function findGeoIpCountryByCode($code)
    {
        return \Entity\GeoIpCountry::findFirst(array(
            "code = ?1",
            "bind"       => array(1 => $code)
        ));
    }

    public function update()
    {

        // to transaction

        $geoFilesContent = file_get_contents('http://ipgeobase.ru/files/db/Main/geo_files.zip');
        $geoFileZip = sys_get_temp_dir() . '/geo_files.zip';
        if ($geoFilesContent) {
            file_put_contents($geoFileZip, $geoFilesContent);

            if (($handle = fopen("zip://" . $geoFileZip . "#cities.txt", "r")) !== false) {
                while (($data = fgetcsv($handle, 4000, "\t")) !== false) {

                    $cityId = $data[0];
                    $cityName = mb_convert_encoding($data[1], 'UTF-8', 'windows-1251');
                    $regionName = mb_convert_encoding($data[2], 'UTF-8', 'windows-1251');
                    $districtName = mb_convert_encoding($data[3], 'UTF-8', 'windows-1251');
                    $lat = $data[4];
                    $lng = $data[5];

                    $geoIpCity = \Entity\GeoIpCity::findFirst($cityId);
                    if (!$geoIpCity) {
                        $geoIpCity = new \Entity\GeoIpCity();
                        $geoIpCity->setId($cityId);
                        $geoIpCity->setCity($cityName);
                        $geoIpCity->setRegion($regionName);
                        $geoIpCity->setDistrict($districtName);
                        $geoIpCity->setLat($lat);
                        $geoIpCity->setLng($lng);
                        if (!$geoIpCity->save()) {
                            throw new ApplicationException($geoIpCity->getMessages());
                        }
                    }

                }
            }
            fclose($handle);

            $currentVersion = $this->getCurrentVersion();
            $nextVersion = $currentVersion + 1;

            if (($handle = fopen("zip://" . $geoFileZip . "#cidr_optim.txt", "r")) !== false) {
                while (($data = fgetcsv($handle, 4000, "\t")) !== false) {

                    $startIp = $data[0];
                    $endIp = $data[1];
                    $countryCode = $data[3];
                    $countryCityId = $data[4];
                    if ($countryCityId == '-') {
                        $countryCityId = null;
                    }

                    $geoCountry = $this->findGeoIpCountryByCode($countryCode);
                    if (!$geoCountry) {
                        $geoCountry = new \Entity\GeoIpCountry();
                        $geoCountry->setCode($countryCode);
                        if (!$geoCountry->save()) {
                            throw new ApplicationException($geoCountry->getMessages());
                        }
                    }
                    $geoCountryId = $geoCountry->getId();

                    $geoIp = new \Entity\GeoIp();
                    $geoIp->setIpFrom($startIp);
                    $geoIp->setIpTo($endIp);
                    $geoIp->setGeoIpCountryId($geoCountryId);
                    $geoIp->setGeoIpCityId($countryCityId);
                    $geoIp->setVersion($nextVersion);

                    if (!$geoIp->save()) {
                        throw new ApplicationException($geoIp->getMessages());
                    }

                }
            }
            fclose($handle);

            $this->removeVersion($currentVersion);
        }

        unlink($geoFileZip);
    }

    public function getIpInfo($ip)
    {
        $result = $this->db->query("SELECT * FROM geo_ip WHERE ip_to >= INET_ATON(:ip) LIMIT 1", ['ip' => $ip]);
        $records = $result->fetchAll();
        return $records[0];
    }

}