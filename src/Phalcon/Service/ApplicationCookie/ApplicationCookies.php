<?php

namespace Sb\Phalcon\Service\ApplicationCookie;

use Phalcon\Di\Injectable;
use Phalcon\Http\Response\Cookies;

class ApplicationCookie extends Injectable
{
    /**
     * @return Cookies
     */
    public function getEncryptedCookies()
    {
        $this->cookies->useEncryption(true);
        return $this->cookies;
    }

    /**
     * @return Cookies
     */
    public function getCookies()
    {
        $this->cookies->useEncryption(false);
        return $this->cookies;
    }
}