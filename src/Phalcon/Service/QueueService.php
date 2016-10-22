<?php

namespace Sb\Phalcon\Service;

use \Phalcon\DiInterface as Di;
use Phalcon\Queue\Beanstalk;

class QueueService
{
    const SERVICE_NAME = 'queue';

    public static function init(Di $di)
    {
        $config = $di->get('config');

        if (!isset($config->queue)) {
            return;
        }

        $params = $config->queue->beanstalk;

        $di->setShared(self::SERVICE_NAME, function() use ($params) {
            return new Beanstalk($params);
        });
    }
}
