<?php

namespace Sb\Phalcon\Helpers;

use Sb\Phalcon\Helpers\Seo\CanonicalLink;
use Sb\Phalcon\Helpers\Seo\OpenGraph;
use Sb\Phalcon\Helpers\Seo\Title;
use Sb\Phalcon\Helpers\Seo\Yandex;

class SeoHelper
{
    private $di = null;

    private $openGraph = null;
    private $canonicalLink = null;
    private $title = null;
    private $yandex = null;

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function getHtmlPrefix()
    {
        $result = 'prefix="';
        if ($this->getOpenGraph()->isAvailable()) {
            $result .= 'og: http://ogp.me/ns#';
        }

        if ($this->getYandex()->isAvailable()) {
            $result .= 'ya: http://webmaster.yandex.ru/vocabularies/';
        }

        $result = trim($result) . '"';
        return $result;
    }

    public function getHeadMetaData()
    {
        $result = '';
        $result .= $this->getTitle()->render();
        $result .= '<meta name="robots" content="index, follow" />';

        if ($this->getCanonicalLink()->isAvailable()) {
            $result .= $this->getCanonicalLink()->render();
        }

        if ($this->getYandex()->isAvailable()) {
            $result .= $this->getYandex()->render();
        }

        if ($this->getOpenGraph()->isAvailable()) {
            $result .= $this->getOpenGraph()->render();
        }

        return $result;
    }

    /**
     * @return \Sb\Phalcon\Helpers\Seo\OpenGraph
     */
    public function getOpenGraph()
    {
        if (!$this->openGraph) {
            $this->openGraph = new OpenGraph();
        }
        return $this->openGraph;
    }

    public function getCanonicalLink()
    {
        if (!$this->canonicalLink) {
            $this->canonicalLink = new CanonicalLink();
        }
        return $this->canonicalLink;
    }

    public function getTitle()
    {
        if (!$this->title) {
            $this->title = new Title();
        }
        return $this->title;
    }

    public function getYandex()
    {
        if (!$this->yandex) {
            $this->yandex = new Yandex();
        }
        return $this->yandex;
    }

} 