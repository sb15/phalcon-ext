<?php

namespace Sb\Phalcon\Plugins;

use Sb\Phalcon\Helpers\BreadcrumbHelper;

class BreadcrumbPlugin
{
    const SERVICE_NAME = 'breadcrumbs-helper';

    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $view = $dispatcher->getDI()->getService('view')->resolve();
        $breadcrumbHelper = $dispatcher->getDI()->get(BreadcrumbHelper::SERVICE_NAME);
        if ($breadcrumbHelper) {
            $view->setVar('breadcrumb', $breadcrumbHelper);
        }
    }
}