<?php

namespace Sb\Phalcon\Model;

use Phalcon\Di\InjectionAwareInterface;
use Phalcon\DiInterface;

class Repository implements InjectionAwareInterface
{
    public $models = array();

    public $di;

    public function getDI()
    {
        return $this->di;
    }

    public function setDI(DiInterface $dependencyInjector)
    {
        $this->di = $dependencyInjector;
    }

    public function getModel($modelName, $namespace = 'Model')
    {
        if (!array_key_exists($modelName, $this->models)) {
            $namespace = '\\'.$namespace.'\\'.$modelName;
            $newModel = new $namespace;
            $newModel->setDI($this->di);
            $this->models[$modelName] = $newModel;
        }
        return $this->models[$modelName];
    }
}