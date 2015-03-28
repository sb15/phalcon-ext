<?php

namespace Sb\Phalcon\Plugins;

class ErrorHandlingPlugin
{
    public function beforeException(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher, \Phalcon\Exception $exception)
    {
        switch ($exception->getCode()) {
            case $dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case $dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $dispatcher->forward(
                    array(
                        'controller' => 'error',
                        'action' => 'notFound',
                    )
                );

            return false;
            default:
                $dispatcher->forward(
                    array(
                        'controller' => 'error',
                        'action' => 'uncaughtException',
                    )
                );
            return false;
        }
    }
}