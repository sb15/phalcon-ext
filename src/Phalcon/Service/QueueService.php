<?php

namespace Sb\Phalcon\Service;

use \Phalcon\DiInterface as Di;
use Phalcon\Queue\Beanstalk;

class QueueService
{
    const SERVICE_NAME = 'queue';

    public static function init(Di $di, $defaultTube = 'default')
    {
        $config = $di->get('config');

        if (!isset($config->queue)) {
            return;
        }

        $params = (array) $config->queue;

        $di->setShared(self::SERVICE_NAME, function() use ($params, $defaultTube) {
            $beanstalk = new Beanstalk($params);
            $beanstalk->choose($defaultTube);
            return $beanstalk;
        });
    }
}
