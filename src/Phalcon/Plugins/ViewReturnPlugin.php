<?php

namespace Sb\Phalcon\Plugins;

class ViewReturnPlugin
{

    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $view = $dispatcher->getDI()->getService('view')->resolve();

        $controllerData = $event->getData();

        if (is_array($controllerData)) {
            foreach ($controllerData as $key => $value) {
                $view->setVar($key, $value);
            }
        }

    }

}
