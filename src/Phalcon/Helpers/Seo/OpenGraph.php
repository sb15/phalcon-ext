<?php

namespace Sb\Phalcon\Helpers\Seo;

class OpenGraph
{
    private $locale = null;
    private $type = null;
    private $title = null;
    private $url = null;
    private $description = null;
    private $site_name = null;
    private $image = null;

    public function isAvailable()
    {
        return (bool)
            $this->locale ||
            $this->type ||
            $this->title ||
            $this->url ||
            $this->description ||
            $this->site_name ||
            $this->image;
    }

    public function render()
    {
        $result = '';
        if ($this->getLocale()) {
            $result .= '    <meta property="og:locale" content="'.$this->getLocale().'" />' . "\n";
        }
        if ($this->getType()) {
            $result .= '    <meta property="og:type" content="'.$this->getType().'" />' . "\n";
        }
        if ($this->getTitle()) {
            $result .= '    <meta property="og:title" content="'.$this->getTitle().'" />' . "\n";
        }
        if ($this->getUrl()) {
            $result .= '    <meta property="og:url" content="'.$this->getUrl().'" />' . "\n";
        }
        if ($this->getDescription()) {
            $result .= '    <meta property="og:description" content="'.$this->getDescription().'" />' . "\n";
        }
        if ($this->getSiteName()) {
            $result .= '    <meta property="og:site_name" content="'.$this->getSiteName().'" />' . "\n";
        }
        if ($this->getImage()) {
            $result .= '    <meta property="og:image" content="'.$this->getImage().'" />' . "\n";
        }
        return $result;
    }

    /**
     * @param null $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return null
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param null $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return null
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param null $site_name
     * @return $this
     */
    public function setSiteName($site_name)
    {
        $this->site_name = $site_name;
        return $this;
    }

    /**
     * @return null
     */
    public function getSiteName()
    {
        return $this->site_name;
    }

    /**
     * @param null $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param null $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return null
     */
    public function getUrl()
    {
        return $this->url;
    }


}