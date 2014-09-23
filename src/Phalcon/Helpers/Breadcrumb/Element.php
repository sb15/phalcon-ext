<?php

namespace Sb\Phalcon\Helpers\Breadcrumb;

class Element
{
    private $url;
    private $name;

    public function __construct($url, $name)
    {
        $this->setName($name);
        $this->setUrl($url);
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

} 