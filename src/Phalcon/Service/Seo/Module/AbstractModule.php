<?php

namespace Sb\Phalcon\Service\Seo\Module;

use Sb\Phalcon\Service\Seo\Seo;

abstract class AbstractModule
{
    private $seo;

    public function __construct(Seo $seo)
    {
        $this->seo = $seo;
    }
    abstract public function render();
}