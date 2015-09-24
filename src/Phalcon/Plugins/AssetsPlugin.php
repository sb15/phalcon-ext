<?php

namespace Sb\Phalcon\Plugins;

use Sb\Phalcon\Helpers\AssetsHelper;

class AssetsPlugin
{
    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $view = $dispatcher->getDI()->getService('view')->resolve();
        $assetsHelper = $dispatcher->getDI()->get(AssetsHelper::SERVICE_NAME);
        if ($assetsHelper) {
            $view->setVar('assets', $assetsHelper);
        }
    }
} 