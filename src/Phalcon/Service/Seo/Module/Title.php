<?php

namespace Sb\Phalcon\Service\Seo\Module;

class Title extends AbstractModule
{
    private $titleParts = array();

    public static $delimiter = " / ";

    public function title($text = null)
    {
        if ($text) {
            array_push($this->titleParts, $text);
        } else {
            return implode(array_reverse($this->titleParts), self::$delimiter);
        }
        return '';
    }

    public function render()
    {
        return "<title>".$this->title()."</title>\n";
    }
} 