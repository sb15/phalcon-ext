<?php

namespace Sb\Phalcon\Model;

class Repository
{
    private $models = array();

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

    public function getModel($modelName)
    {
        if (!array_key_exists($modelName, $this->models)) {
            $namespace = '\\'.$this->namespace.'\\'.$modelName . $this->postfix;
            $newModel = new $namespace;
            $this->models[$modelName] = $newModel;
        }
        return $this->models[$modelName];
    }
}