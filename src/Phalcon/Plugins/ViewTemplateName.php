<?php

namespace Sb\Phalcon\Plugins;

class ViewTemplateName
{
    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        /** @var \Phalcon\Mvc\Router $route */
        $route = $dispatcher->getDI()->get('router');

        $view = $dispatcher->getDI()->getService('view')->resolve();
        $wasForwarded = $dispatcher->wasForwarded();
        
        if ($wasForwarded) {
            return;
        }

        if ($route->getMatchedRoute()) {
            $paths = $route->getMatchedRoute()->getPaths();
            $controller = $paths['controller'];
            $action = \Phalcon\Text::uncamelize($paths['action']);
            $action = str_replace("_", "-", $action);

            $template = $controller . '/' . $action;
            $view->pick([$template]);
        }
    }
}