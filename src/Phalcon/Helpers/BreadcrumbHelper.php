<?php

namespace Sb\Phalcon\Helpers;

use Sb\Phalcon\Helpers\Breadcrumb\Element;

class BreadcrumbHelper
{
    const SERVICE_NAME = 'breadcrumbs-helper';

    private $breadcrumbs = array();

    private $di = null;

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function exist()
    {
        return (bool) count($this->breadcrumbs);
    }

    public function addBreadcrumb($url, $name)
    {
        $this->breadcrumbs[] = new Element($url, $name);
    }

    /**
     * @return Element[]
     */
    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }

    public function count()
    {
        return count($this->breadcrumbs);
    }

} 