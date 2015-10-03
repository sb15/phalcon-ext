<?php

namespace Sb\Phalcon\Plugins;

class TranslationPlugin
{
    public function beforeExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {

        /** @var \Phalcon\Http\Request $request */
        $request = $dispatcher->getDI()->getService('request')->resolve();

        if ($dispatcher->getParam('lang')) {
            $lang = $dispatcher->getParam('lang');
        } else {
            $lang = $request->getBestLanguage();
        }

        $view = $dispatcher->getDI()->getService('view')->resolve();

        $translationHelper = $dispatcher->getDI()->get(\Sb\Phalcon\Helpers\TranslationHelper::SERVICE_NAME);
        $translationHelper->setLang($lang);
        $view->setVar('t', $translationHelper->getTranslation());

    }
}