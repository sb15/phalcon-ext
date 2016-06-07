<?php

namespace Sb\Phalcon\Service;

use \Phalcon\DiInterface as Di;
use Sb\Phalcon\Service\Tag\Tag;

class TagService
{
    const SERVICE_NAME = 'tag';

    public static function init(Di $di)
    {
        $di->setShared(self::SERVICE_NAME, function() {
            return new Tag();
        });
    }
}
