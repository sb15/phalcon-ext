<?php

namespace Sb\Phalcon\Service;

use Phalcon\DiInterface as Di;
use Service\Auth\Auth;

class AuthService
{
    const SERVICE_NAME = 'auth';

    public static function init(Di $di, $userModelName = null)
    {
        $di->setShared(self::SERVICE_NAME, function() use ($userModelName) {
            return new Auth($userModelName);
        });
    }

}