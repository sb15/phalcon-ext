<?php

namespace Sb\Phalcon\Service;

use \Phalcon\DiInterface as Di;
use Sb\Phalcon\Service\GeoIp\GeoIp;

class GeoIpService
{
    const SERVICE_NAME = 'geoIp';

    public static function init(Di $di)
    {
        $di->setShared(self::SERVICE_NAME, function() {
            return new GeoIp();
        });
    }
}
