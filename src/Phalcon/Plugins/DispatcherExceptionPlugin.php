<?php

namespace Sb\Phalcon\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class DispatcherExceptionPlugin
{
    public function beforeException(Event $event, Dispatcher $dispatcher, $exception)
    {
        $dispatcher->getEventsManager()->fire('dispatch:afterDispatchLoop', $dispatcher);
        $view = $dispatcher->getDI()->get('view');
        $response = $dispatcher->getDI()->get('response');

        if ($exception instanceof Dispatcher\Exception) {
            $siteUrl = '';
            if (defined(SITE_URL)) {
                $siteUrl = SITE_URL;
            }
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                case Dispatcher::EXCEPTION_CYCLIC_ROUTING:
                    $view->setVar('exception', $exception);
                    $view->render('error', 'notFound');
                    $response->setStatusCode(404, 'Not Found');
                    $response->send();
                    break;
                case 301:
                    $response->redirect($siteUrl . $exception->getMessage(), true, 301);
                    $response->send();
                    break;
                case 302:
                    $response->redirect($siteUrl . $exception->getMessage(), true, 302);
                    $response->send();
                    break;
                default:
                    if ($dispatcher->getDI()->has('sentry')) {
                        $dispatcher->getDI()->get('sentry')->captureException($exception);
                    }
                    $view->setVar('exception', $exception);
                    $view->render('error', 'uncaughtException');
                    $response->setStatusCode(500, 'Internal Server Error');
                    $response->send();
            }
        } else {
            if ($dispatcher->getDI()->has('sentry')) {
                $dispatcher->getDI()->get('sentry')->captureException($exception);
            }
            $view->setVar('exception', $exception);
            $view->render('error', 'uncaughtException');
            $response->setStatusCode(500, 'Internal Server Error');
            $response->send();
        }
        exit;
    }
}