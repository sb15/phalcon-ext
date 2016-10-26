<?php

namespace Sb\Phalcon\Service;

use Phalcon\DiInterface as Di;
use Sb\Phalcon\Service\ApplicationCookie\ApplicationCookie;

class ApplicationCookieService
{
    const SERVICE_NAME = 'applicationCookie';

    public static function init(Di $di)
    {
        $di->setShared(self::SERVICE_NAME, function() {
            return new ApplicationCookie();
        });
    }

}