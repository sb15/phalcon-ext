<?php

namespace Sb\Phalcon\Plugins;

class ViewReturnPlugin
{
    const SET_JSON_RESPONSE = '_set_json_response';

    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $view = $dispatcher->getDI()->getService('view')->resolve();

        $returnedValue = $dispatcher->getReturnedValue();

        if (array_key_exists(self::SET_JSON_RESPONSE, $returnedValue)) {
            $view->disable();
            header('Content-type: application/json');
            unset($returnedValue[self::SET_JSON_RESPONSE]);
            echo json_encode($returnedValue);
            return;
        }

        if (is_array($returnedValue)) {
            $view->setVars($returnedValue);
        }

    }
}
