<?php

namespace Sb\Phalcon\Helpers;

class BreadcrumbHelper
{
    private $di = null;

    public function __construct($di)
    {
        $this->di = $di;
    }
} 