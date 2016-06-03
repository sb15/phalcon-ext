<?php

namespace Sb\Phalcon\Service\Seo\Module;

class CanonicalLink extends AbstractModule
{
    private $canonical = null;
    private $prev = null;
    private $next = null;

    public function isAvailable()
    {
        return (bool) $this->canonical;
    }

    public function render()
    {
        $result = '';
        if ($this->getCanonical()) {
            $result .= '    <link rel="canonical" href="'.$this->getCanonical().'" />' . "\n";
        }
        if ($this->getNext()) {
            $result .= '    <link rel="next" href="'.$this->getNext().'" />' . "\n";
        }
        if ($this->getPrev()) {
            $result .= '    <link rel="prev" href="'.$this->getPrev().'" />' . "\n";
        }
        return $result;
    }

    /**
     * @param null $canonical
     * @return $this
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;
        return $this;
    }

    /**
     * @return null
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @param null $next
     * @return $this
     */
    public function setNext($next)
    {
        $this->next = $next;
        return $this;
    }

    /**
     * @return null
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @param null $prev
     * @return $this
     */
    public function setPrev($prev)
    {
        $this->prev = $prev;
        return $this;
    }

    /**
     * @return null
     */
    public function getPrev()
    {
        return $this->prev;
    }

} 