<?php

namespace Sb\Phalcon\Plugins;

use Sb\Phalcon\Helpers\AnalyticsHelper;

class AnalyticsPlugin
{
    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $view = $dispatcher->getDI()->getService('view')->resolve();
        $analyticsHelper = $dispatcher->getDI()->get(AnalyticsHelper::SERVICE_NAME);
        if ($analyticsHelper) {
            $view->setVar('analytics', $analyticsHelper);
        }
    }
} 