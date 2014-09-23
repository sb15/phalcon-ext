<?php

namespace Sb\Phalcon\Helpers;

class BreadcrumbHelper
{
    const SERVICE_NAME = 'breadcrumbs-helper';

    private $di = null;

    public function __construct($di)
    {
        $this->di = $di;
    }
} 