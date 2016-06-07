<?php

namespace Sb\Phalcon\Service;

use \Phalcon\DiInterface as Di;
use \Sb\Phalcon\Service\Path\Path;

class PathService
{
    const SERVICE_NAME = 'path';

    public static function init(Di $di)
    {
        $di->setShared(self::SERVICE_NAME, function() {
            return new Path();
        });
    }
}
