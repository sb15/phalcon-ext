<?php

namespace Sb\Phalcon\Helpers;

class AssetHelper
{
    const SERVICE_NAME = 'asset-helper';

    private $di = null;

    private $isCssCodeInitiated = false;
    private $isJsCodeInitiated = false;

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function asyncCss($files)
    {
        if (!$this->isCssCodeInitiated) {
            $this->flushCssCode();
            $this->isCssCodeInitiated = true;
        }

        if (!is_array($files)) {
            $files = [];
        }

        echo "<script>\n";
        foreach ($files as $file) {
            echo "   loadCSS(\"{$file}\");\n";
        }
        echo "</script>\n";

        foreach ($files as $file) {
            echo "<noscript><link href=\"{$file}\" rel=\"stylesheet\"></noscript>\n";
        }
    }

    public function asyncJs($files)
    {
        if ($this->isJsCodeInitiated) {
            $this->flushJsCode();
            $this->isJsCodeInitiated = true;
        }

        if (!is_array($files)) {
            $files = [];
        }

        echo "<script>\n";
        foreach ($files as $file) {
            echo "   loadJS(\"{$file}\");\n";
        }
        echo "</script>\n";
    }

    private function flushCssCode()
    {
        echo "<script>" . $this->getCssCode() . "</script>\n";
    }

    private function flushJsCode()
    {
        echo "<script>" . $this->getJsCode() . "</script>\n";
    }

    private function getCssCode() {
        return 'function loadCSS(e,n,o,t){"use strict";var d=window.document.createElement("link"),i=n||window.document.getElementsByTagName("script")[0],r=window.document.styleSheets;return d.rel="stylesheet",d.href=e,d.media="only x",t&&(d.onload=t),i.parentNode.insertBefore(d,i),d.onloadcssdefined=function(e){for(var n,o=0;o<r.length;o++)r[o].href&&r[o].href===d.href&&(n=!0);n?e():setTimeout(function(){d.onloadcssdefined(e)})},d.onloadcssdefined(function(){d.media=o||"all"}),d};';
    }

    private function getJsCode() {
        return 'function loadJS(e,t){"use strict";var n=window.document.getElementsByTagName("script")[0],o=window.document.createElement("script");return o.src=e,o.async=!0,n.parentNode.insertBefore(o,n),t&&"function"==typeof t&&(o.onload=t),o};';
    }

} 