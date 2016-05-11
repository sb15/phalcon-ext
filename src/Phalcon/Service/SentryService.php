<?php

namespace Sb\Phalcon\Service;

use \Phalcon\DiInterface as Di;

class SentryService
{
    const SERVICE_NAME = 'sentry';

    public static function init(Di $di, $isDevelopment = false)
    {
        $config = $di->get('config');

        $sentryDsn = '';
        if (isset($config->sentry->dsn)) {
            $sentryDsn = $config->sentry->dsn;
        }

        $client = new \Raven_Client($sentryDsn);

        if ($isDevelopment) {
            error_reporting(E_ALL);
            ini_set('display_errors' , 1);
        } else {
            $error_handler = new \Raven_ErrorHandler($client);
            $error_handler->registerExceptionHandler();
            $error_handler->registerErrorHandler();
            $error_handler->registerShutdownFunction();
        }

        $di->set(self::SERVICE_NAME, function() use ($client) {
            return $client;
        });
    }
}
