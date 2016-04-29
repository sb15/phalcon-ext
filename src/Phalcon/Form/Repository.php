<?php

namespace Sb\Phalcon\Form;

class Repository
{
    private $forms = array();

    private $namespace = 'Form';

    private $postfix = 'Form';

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    public function setPostfix($postfix)
    {
        $this->postfix = $postfix;
    }

    public function getForm($formName)
    {
        if (!array_key_exists($formName, $this->forms)) {
            $namespace = '\\'.$this->namespace.'\\'.$formName . $this->postfix;
            $newModel = new $namespace;
            $this->forms[$formName] = $newModel;
        }
        return $this->forms[$formName];
    }
}