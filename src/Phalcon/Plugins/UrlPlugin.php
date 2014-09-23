<?php

namespace Sb\Phalcon\Plugins;

use Sb\Phalcon\Helpers\UrlHelper;

class UrlPlugin
{
    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $view = $dispatcher->getDI()->getService('view')->resolve();
        $urlHelper = $dispatcher->getDI()->get(UrlHelper::SERVICE_NAME);
        if ($urlHelper) {
            $view->setVar('url', $urlHelper);
        }
    }
}