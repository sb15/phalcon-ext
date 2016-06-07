<?php

namespace Sb\Phalcon\Service\Path;

use Phalcon\Di\Injectable;

class Path extends Injectable 
{
    public function get($routeName, $routeParams = [])
    {
        $url = $this->di->get('url');

        $options = array(
            'for' => $routeName
        );

        $options = array_merge($options, $routeParams);

        return $url->get($options);
    }
}