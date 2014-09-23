<?php

namespace Sb\Phalcon\Plugins;

use Sb\Phalcon\Helpers;

class UrlPlugin
{
    const SERVICE_NAME = 'url-helper';

    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $view = $dispatcher->getDI()->getService('view')->resolve();
        $view->setVar('url', new Helpers\UrlHelper($dispatcher->getDI()));
    }
}