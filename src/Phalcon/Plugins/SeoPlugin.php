<?php

namespace Sb\Phalcon\Plugins;

class SeoPlugin
{
    const SERVICE_NAME = 'seo-helper';

    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $view = $dispatcher->getDI()->getService('view')->resolve();
        $seoHelper = $dispatcher->getDI()->get(self::SERVICE_NAME);
        if ($seoHelper) {
            $view->setVar('seo', $seoHelper);
        }
    }
} 