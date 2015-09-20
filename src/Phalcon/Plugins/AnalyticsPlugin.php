<?php

namespace Sb\Phalcon\Plugins;

use Sb\Phalcon\Helpers\AnalyticsHelper;

class AnalyticsPlugin
{
    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $view = $dispatcher->getDI()->getService('view')->resolve();
        $seoHelper = $dispatcher->getDI()->get(AnalyticsHelper::SERVICE_NAME);
        if ($seoHelper) {
            $view->setVar('seo', $seoHelper);
        }
    }
} 