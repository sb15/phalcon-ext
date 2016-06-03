<?php

namespace Sb\Phalcon\Service\Seo\Module;

class Meta extends AbstractModule
{
    private $metaList = [];

    /**
     * @param string $robots
     * @return $this
     */
    public function setRobots($robots)
    {
        $this->addMeta('robots', $robots);
        return $this;
    }

    /**
     * @param null $keywords
     * @return $this
     */
    public function setKeywords($keywords)
    {
        $this->addMeta('keywords', $keywords);
        return $this;
    }

    /**
     * @param null $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->addMeta('description', $description);
        return $this;
    }

    public function addMeta($name, $content)
    {
        $this->metaList[$name] = $content;
    }

    public function getMetaList()
    {
        return $this->metaList;
    }

    public function render()
    {
        $result = '';

        if ($this->getMetaList()) {
            foreach ($this->getMetaList() as $metaName => $metaValue) {
                $result .= '    <meta name="'. $metaName .'" content="' . str_replace('"', '', $metaValue) . '"/>' . "\n";
            }
        }

        return $result;
    }

} 