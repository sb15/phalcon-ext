<?php

namespace Sb\Phalcon\Plugins;

use Sb\Phalcon\Helpers\ViewHelper;

class ViewHelperPlugin
{
    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $view = $dispatcher->getDI()->getService('view')->resolve();
        $viewHelper = $dispatcher->getDI()->get(ViewHelper::SERVICE_NAME);
        if ($viewHelper) {
            $view->setVar('helper', $viewHelper);
        }
    }
}