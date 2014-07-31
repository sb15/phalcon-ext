<?php

namespace Sb\Phalcon\Helpers;

class EmailHelper
{

    private $di = null;
    private $partialView = null;

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function getLetter($template, $params = array())
    {
        if (is_null($this->partialView)) {
            $applicationConfig = $this->di->get('applicationConfig');
            $this->partialView = new \Phalcon\Mvc\View();
            $this->partialView->setViewsDir($applicationConfig['viewsDir']);
            $this->partialView->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
            $this->partialView->setVar('url', new \PhalconEx\Helpers\UrlHelper($this->di));
        }

        foreach ($params as $paramKey => $paramValue) {
            $this->partialView->setVar($paramKey, $paramValue);
        }

        list($action, $controller) = explode("/", $template);
        $this->partialView->start();
        $this->partialView->render($action, $controller);
        $this->partialView->finish();

        return $this->partialView->getContent();

    }

}