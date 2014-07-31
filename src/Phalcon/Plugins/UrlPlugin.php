<?php

namespace Sb\Phalcon\Plugins;

class UrlPlugin
{

    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $view = $dispatcher->getDI()->getService('view')->resolve();
        $view->setVar('url', new \PhalconEx\Helpers\UrlHelper($dispatcher->getDI()));
    }

}