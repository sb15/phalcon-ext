<?php

namespace Sb\Phalcon\Service\Breadcrumb;

use Phalcon\Di\Injectable;

class Breadcrumb extends Injectable
{
    private $breadcrumbs = array();

    public function exist()
    {
        return (bool) count($this->breadcrumbs);
    }

    /**
     * @param $url
     * @param $name
     * @return $this
     */
    public function addBreadcrumb($url, $name)
    {
        $this->breadcrumbs[] = new Element($url, $name);
        return $this;
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