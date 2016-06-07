<?php

namespace Sb\Phalcon\Service\Tag;

class Tag extends \Phalcon\Tag
{
	static public function path($routeName, $routeParams = [])
	{
		self:$di->get('path')->get($routeName, $routeParams);
	}

    static public function formatPhoneRu($phone, $cityCode = '')
    {
        $phone = preg_replace("#[^0-9]+#uis", "", $phone);

        if (strlen($phone) == 7) {
            $phone = $cityCode . $phone;
        }

        if (strlen($phone) == 10) {
            $phone = '8' . $phone;
        }

        if (preg_match("#^7(.*)#uis", $phone, $m)) {
            $phone = '8' . $m[1];
        }


        return substr($phone, 0, 1) . ' (' . substr($phone, 1, 3) . ') ' . 
        	   substr($phone, 4, 3) . '-' . substr($phone, 7, 2) . '-' . substr($phone, 9, 2);
                

        return $phone;
    }

    static public function formatPrice($price, $decimals = 0, $decimalsSeparator = ',', $thousandsSeparator = ' ')
    {
        return number_format($price, $decimals, $decimalsSeparator, $thousandsSeparator);
    }
}