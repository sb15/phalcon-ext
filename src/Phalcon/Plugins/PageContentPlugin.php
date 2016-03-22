<?php

namespace Sb\Phalcon\Plugins;

class PageContentPlugin
{
    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        /** @var \Model\ModelsRepository $modelsRepository */
        $modelsRepository = $dispatcher->getDI()->getService('modelsRepository')->resolve();

        if (!$modelsRepository) {
            return;
        }

        $returnedValue = $dispatcher->getReturnedValue();
        if (is_null($returnedValue)) {
            $returnedValue = [];
        }
        $modelsRepository->getPageContent()->processContent($dispatcher->getParams(), $returnedValue);
    }
}
