<?php
namespace Sb\Phalcon\Helpers;

class EmailHelper
{
    const SERVICE_NAME = 'email-helper';

    private $di = null;
    private $view = null;
    private $templateDir = null;

    public function __construct($di, $templateDir)
    {
        $this->di = $di;
        $this->templateDir = $templateDir;
    }

    public function getEmail($language, $template, $params = [])
    {
        if (is_null($this->view)) {
            $this->view = new \Phalcon\Mvc\View\Simple();
            $this->view->setViewsDir($this->templateDir);
        }

        return $this->view->render($language . '/' . $template, $params);
    }
}