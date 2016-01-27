<?php

namespace Sb\Phalcon\Helpers;

class PhoneHelper
{
    const SERVICE_NAME = 'phone-helper';

    const FORMAT_TYPE_DEFAULT = 'default';
    const FORMAT_TYPE_NUMBERS = 'numbers';

    /**
     * @var \Phalcon\DI\FactoryDefault
     */
    private $di = null;

    private $cityCode = '';

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function setCityCode($cityCode)
    {
        $this->cityCode = $cityCode;
    }

    public function format($phone, $formatType = self::FORMAT_TYPE_DEFAULT)
    {
        $phone = preg_replace("#[^0-9]+#uis", "", $phone);

        if (strlen($phone) == 7) {
            $phone = $this->cityCode . $phone;
        }

        if (strlen($phone) == 10) {
            $phone = '8' . $phone;
        }

        if (preg_match("#^7(.*)#uis", $phone, $m)) {
            $phone = '8' . $m[1];
        }

        switch ($formatType) {
            case self::FORMAT_TYPE_DEFAULT:

                return substr($phone, 0, 1) . ' (' . substr($phone, 1, 3) . ') ' . substr($phone, 4, 3) . '-' . substr($phone, 7, 2) . '-' . substr($phone, 9, 2);
            break;
            case self::FORMAT_TYPE_NUMBERS:

                return preg_replace("#[^0-9]+#uis", "", $phone);
            break;
        }

        return $phone;
    }
}