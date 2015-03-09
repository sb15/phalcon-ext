<?php

namespace Sb\Phalcon\Helpers;

use Sb\Phalcon\Helpers\Seo\CanonicalLink;
use Sb\Phalcon\Helpers\Seo\Meta;
use Sb\Phalcon\Helpers\Seo\OpenGraph;
use Sb\Phalcon\Helpers\Seo\Title;
use Sb\Phalcon\Helpers\Seo\Yandex;

class SeoHelper
{
    const SERVICE_NAME = 'seo-helper';

    private $di = null;

    private $openGraph = null;
    private $canonicalLink = null;
    private $title = null;
    private $yandex = null;
    private $meta = null;

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function renderHtmlPrefix()
    {
        $result = 'prefix="';
        if ($this->getOpenGraph()->isAvailable()) {
            $result .= 'og: http://ogp.me/ns# ';
        }

        $ogPrefix = $this->getOpenGraph()->getOgPrefix();
        if ($ogPrefix) {
            $result .= $ogPrefix . ' ';
        }

        if ($this->getYandex()->isAvailable()) {
            $result .= 'ya: http://webmaster.yandex.ru/vocabularies/ ';
        }

        $result = trim($result) . '"';
        return $result;
    }

    public function render()
    {
        $result = '';
        $result .= $this->getTitle()->render();
        $result .= $this->getMeta()->render();
        $result .= $this->getCanonicalLink()->render();
        $result .= $this->getYandex()->render();
        $result .= $this->getOpenGraph()->render();
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

    public function getMeta()
    {
        if (!$this->meta) {
            $this->meta = new Meta();
        }
        return $this->meta;
    }

} 