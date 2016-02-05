<?php

namespace Sb\Phalcon\Helpers\Seo;

class JsonLd
{
    private $blocks = [];

    public function addJsonLd($content)
    {
        $this->blocks[] = $content;
    }

    public function addSiteNameMarkup($name, $alternateName, $url)
    {
        $this->blocks[] = '
        {
          "@context" : "http://schema.org",
          "@type" : "WebSite",
          "name" : "'.$name.'",
          "alternateName" : "'.$alternateName.'",
          "url" : "'.$url.'"
        }';
    }

    public function addSearchBoxMarkup($url, $target, $queryInputName)
    {
        $this->blocks[] = '
        {
          "@context": "http://schema.org",
          "@type": "WebSite",
          "url": "'.$url.'",
          "potentialAction": {
            "@type": "SearchAction",
            "target": "'.$target.'{'.$queryInputName.'}",
            "query-input": "required name='.$queryInputName.'"
          }
        }';
    }

    /**
     * @param \Sb\Phalcon\Helpers\Breadcrumb\Element[] $breadcrumbs
     */
    public function addBreadcrumbsMarkup($breadcrumbs)
    {
        $itemListElement = [];

        $position = 1;
        foreach ($breadcrumbs as $breadcrumb) {
            $itemListElement[] = [
                "@type" => "ListItem",
                "position" => $position,
                "item" => [
                    "@id" => $breadcrumb->getUrl(),
                    "name" => $breadcrumb->getName()
                ]
            ];
            $position++;
        }

        $this->blocks[] = '
        {
          "@context": "http://schema.org",
          "@type": "BreadcrumbList",
          "itemListElement": '.json_encode($itemListElement).'
        }';
    }

    public function render()
    {
        $result = '';
        foreach ($this->blocks as $block) {
            $result .= "<script type=\"application/ld+json\">";
            $result .= $block;
            $result .= "</script>";
        }

        return $result;
    }
}