<?php

namespace Sb\Phalcon\Plugins;

class ViewReturnPlugin
{
    const SET_JSON_RESPONSE = '_set_json_response';

    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        /** @var \Phalcon\Mvc\View $view */
        $view = $dispatcher->getDI()->getService('view')->resolve();

        $returnedValue = $dispatcher->getReturnedValue();

        if ($returnedValue instanceof \Phalcon\Http\Response) {
            return false;
        }

        if (is_array($view->getParamsToView()) && array_key_exists(self::SET_JSON_RESPONSE, $view->getParamsToView())) {
            $view->disable();
            header('Content-type: application/json');
            echo json_encode($returnedValue);
            return false;
        }

        if (is_array($returnedValue)) {
            $view->setVars($returnedValue);
        }
    }
}
