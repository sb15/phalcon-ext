<?php

namespace Sb\Phalcon\Task;

class DefaultTask extends \Phalcon\CLI\Task
{
    /**
     * @return \Model\ModelsRepository
     */
    public function getModels()
    {
        return $this->getDI()->get('modelsRepository');
    }

    /**
     * @return \Phalcon\Cache\BackendInterface
     */
    public function getFastCache()
    {
        return $this->getDI()->get('fastCache');
    }

    /**
     * @return \Phalcon\Cache\BackendInterface
     */
    public function getSlowCache()
    {
        return $this->getDI()->get('slowCache');
    }
}