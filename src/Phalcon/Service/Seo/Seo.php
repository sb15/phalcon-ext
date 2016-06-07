<?php

namespace Sb\Phalcon\Service\Seo;

use Phalcon\Di\Injectable;
use Sb\Phalcon\Service\Seo\Module\CanonicalLink;
use Sb\Phalcon\Service\Seo\Module\Meta;
use Sb\Phalcon\Service\Seo\Module\OpenGraph;
use Sb\Phalcon\Service\Seo\Module\Title;
use Sb\Phalcon\Service\Seo\Module\Yandex;
use Sb\Phalcon\Service\Seo\Module\JsonLd;

class Seo extends Injectable
{
    private $openGraph = null;
    private $canonicalLink = null;
    private $title = null;
    private $yandex = null;
    private $meta = null;
    private $jsonLd = null;

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
        $result .= $this->getJsonLd()->render();
        return $result;
    }

    /**
     * @return \Sb\Phalcon\Helpers\Seo\OpenGraph
     */
    public function getOpenGraph()
    {
        if (!$this->openGraph) {
            $this->openGraph = new OpenGraph($this);
        }
        return $this->openGraph;
    }

    public function getCanonicalLink()
    {
        if (!$this->canonicalLink) {
            $this->canonicalLink = new CanonicalLink($this);
        }
        return $this->canonicalLink;
    }

    public function getTitle()
    {
        if (!$this->title) {
            $this->title = new Title($this);
        }
        return $this->title;
    }

    public function getYandex()
    {
        if (!$this->yandex) {
            $this->yandex = new Yandex($this);
        }
        return $this->yandex;
    }

    public function getMeta()
    {
        if (!$this->meta) {
            $this->meta = new Meta($this);
        }
        return $this->meta;
    }

    public function getJsonLd()
    {
        if (!$this->jsonLd) {
            $this->jsonLd = new JsonLd($this);
        }
        return $this->jsonLd;
    }

}