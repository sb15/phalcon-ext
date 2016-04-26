<?php

namespace Sb\Phalcon\Model;

use Phalcon\Di\InjectionAwareInterface;
use Phalcon\DiInterface;

class Repository implements InjectionAwareInterface
{
    private $models = array();

    private $di;

    private $namespace = 'Model';

    private $postfix = 'Model';

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    public function setPostfix($postfix)
    {
        $this->postfix = $postfix;
    }

    public function getDI()
    {
        return $this->di;
    }

    public function setDI(DiInterface $dependencyInjector)
    {
        $this->di = $dependencyInjector;
    }

    public function getModel($modelName)
    {
        if (!array_key_exists($modelName, $this->models)) {
            $namespace = '\\'.$this->namespace.'\\'.$modelName . $this->postfix;
            $newModel = new $namespace;
            $newModel->setDI($this->di);
            $this->models[$modelName] = $newModel;
        }
        return $this->models[$modelName];
    }
}