<?php

namespace Sb\Phalcon\Service;

use \Phalcon\DiInterface as Di;
use Sb\Phalcon\Service\Breadcrumb\Breadcrumb;

class BreadcrumbService
{
    const SERVICE_NAME = 'breadcrumb';

    public static function init(Di $di)
    {
        $di->setShared(self::SERVICE_NAME, function() {
            return new Breadcrumb();
        });
    }
}
