<?php

namespace Sb\Phalcon\Http\Response;

use Phalcon\Http\Response;

class Json extends Response
{
    public function __construct($content = null, $code = null, $status = null)
    {
        parent::__construct();
        $this->setJsonContent($content);
    }
}