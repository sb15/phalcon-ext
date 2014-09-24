<?php

namespace Sb\Phalcon\Helpers\Seo;

class Meta
{
    private $keywords = null;
    private $description = null;
    private $robots = 'index, follow';

    /**
     * @param string $robots
     */
    public function setRobots($robots)
    {
        $this->robots = $robots;
    }

    /**
     * @return string
     */
    public function getRobots()
    {
        return $this->robots;
    }

    /**
     * @param null $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return null
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function render()
    {
        $result = '';
        if ($this->getDescription()) {
            $result .= '    <meta name="description" content="'.$this->getDescription().'"/>' . "\n";
        }
        if ($this->getKeywords()) {
            $result .= '    <meta name="keywords" content="'.$this->getKeywords().'"/>' . "\n";
        }
        if ($this->getRobots()) {
            $result .= '    <meta name="robots" content="'.$this->getRobots().'"/>' . "\n";
        }
        return $result;
    }

} 