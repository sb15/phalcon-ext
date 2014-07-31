<?php

namespace Sb\Phalcon\Helpers;

class UrlHelper
{

    private $di = null;

    public function __construct($di)
    {
        $this->di = $di;
    }


    public function get($routeName, $routeParams = array())
    {
        $url = $this->di->get('url');

        $options = array(
            'for' => $routeName
        );

        $options = array_merge($options, $routeParams);

        return $url->get($options);
    }

}