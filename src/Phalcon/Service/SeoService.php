<?php

namespace Sb\Phalcon\Service;

use \Phalcon\DiInterface as Di;
use Sb\Phalcon\Service\Seo\Seo;

class SeoService
{
    const SERVICE_NAME = 'seo';

    public static function init(Di $di)
    {
        $di->setShared(self::SERVICE_NAME, function() {
            return new Seo();
        });
    }
}
