<?php

namespace Sb\Phalcon\Helpers;

class AssetsHelper
{
    const SERVICE_NAME = 'assets-helper';

    const ASSET_TYPE_CSS = 'css';
    const ASSET_TYPE_JS = 'js';

    private $di = null;

    private $headerAssets = [
        self::ASSET_TYPE_CSS => [],
        self::ASSET_TYPE_JS => [],
    ];

    private $footerAssets = [
        self::ASSET_TYPE_CSS => [],
        self::ASSET_TYPE_JS => [],
    ];

    private $scripts = [];

    public function __construct($di)
    {
        $this->di = $di;
    }

    private $asyncLoadRendered = false;

    public function renderAsyncLoad()
    {
        $result = "";
        if ($this->asyncLoadRendered) {
            return $result;
        }

        if ($this->isAsyncLoadCssExist()) {
            $result .= $this->flushCssCode();
        }

        if ($this->isAsyncLoadJsExist()) {
            $result .=$this->flushJsCode();
        }

        $this->asyncLoadRendered = true;
        return $result;
    }

    public function header()
    {
        $result = "";
        $result .= $this->renderAsyncLoad();
        $result .= $this->renderAssets($this->headerAssets);
        return $result;
    }

    public function footer()
    {
        $result = "";
        $result .= $this->renderAsyncLoad();
        $result .= $this->renderAssets($this->footerAssets);

        if (count($this->scripts)) {
            $result .= "<script>\n" . implode("\n\n", $this->scripts) . "</script>";
        }

        return $result;
    }

    private function sortByPriority($asset)
    {
        $firstOrder = [];
        $secondOrder = [];

        foreach($asset as $element) {
            if ($element['priority'] == 100) {
                $firstOrder[] = $element;
            } elseif ($element['priority'] == 200) {
                $secondOrder[] = $element;
            }
        }

        return array_merge($firstOrder, $secondOrder);
    }

    private function renderAssets($assets)
    {
        $result = '';

        $css = $assets[self::ASSET_TYPE_CSS];
        $js = $this->sortByPriority($assets[self::ASSET_TYPE_JS]);

        foreach ($css as $option) {

            if (array_key_exists('ifCondition', $option) && $option['ifCondition']) {
                $result .= "<!--[if {$option['ifCondition']}]>\n";
            }

            if ($option['asyncLoad'] == true) {
            } else {
                $result .= "<link rel=\"stylesheet\" href=\"{$option['path']}\"/>\n";
            }

            if (array_key_exists('ifCondition', $option) && $option['ifCondition']) {
                $result .= "<![endif]-->\n";
            }
        }

        foreach ($js as $option) {

            if (array_key_exists('ifCondition', $option) && $option['ifCondition']) {
                $result .= "<!--[if {$option['ifCondition']}]>\n";
            }

            if ($option['async'] == true) {
                $result .= "<script src=\"{$option['path']}\" async></script>\n";
            } elseif ($option['asyncLoad'] == true) {
            } else {
                $result .= "<script src=\"{$option['path']}\"></script>\n";
            }

            if (array_key_exists('ifCondition', $option) && $option['ifCondition']) {
                $result .= "<![endif]-->\n";
            }
        }

        $asyncLoadListCss = [];
        foreach ($css as $option) {
            if ($option['asyncLoad'] == true) {
                $asyncLoadListCss[] = $option['path'];
            }
        }
        if (count($asyncLoadListCss)) {
            $result .= $this->asyncCss($asyncLoadListCss);
        }

        $asyncLoadListJs = [];
        foreach ($js as $option) {
            if ($option['asyncLoad'] == true) {
                $asyncLoadListJs[] = $option['path'];
            }
        }
        if (count($asyncLoadListJs)) {
            $result .= $this->asyncJs($asyncLoadListJs);
        }

        return $result;
    }

    private function processScript($buffer)
    {
        $buffer = trim($buffer);
        $buffer = preg_replace("#^<script[^>]*>#uis", "", $buffer);
        $buffer = preg_replace("#</script>$#uis", "", $buffer);
        $this->scripts[] = trim($buffer);
        return '';
    }

    public function startScript()
    {
        ob_start();
    }

    public function endScript()
    {
        $result = ob_get_clean();
        $this->scripts[] = $this->processScript($result);
        return $result;
    }

    public function addHeaderCssPost($options)
    {
        if (!is_array($options)) {
            $options = [
                'path' => $options
            ];
        }
        $options['priority'] = 200;
        $this->addHeaderCss($options);
    }

    public function addHeaderCss($options)
    {
        if (!is_array($options)) {
            $options = [
                'path' => $options
            ];
        }

        if (!array_key_exists('asyncLoad', $options)) {
            $options['asyncLoad'] = false;
        }
        if (!array_key_exists('ifCondition', $options)) {
            $options['ifCondition'] = false;
        }
        if (!array_key_exists('priority', $options)) {
            $options['priority'] = 100;
        }

        $this->headerAssets[self::ASSET_TYPE_CSS][] = [
            'path' => $options['path'],
            'asyncLoad' => $options['asyncLoad'],
            'ifCondition' => $options['ifCondition'],
            'priority' => $options['priority'],
        ];
    }

    public function addHeaderJsPost($options)
    {
        if (!is_array($options)) {
            $options = [
                'path' => $options
            ];
        }
        $options['priority'] = 200;
        $this->addHeaderJs($options);
    }

    public function addHeaderJs($options)
    {
        if (!is_array($options)) {
            $options = [
                'path' => $options
            ];
        }

        if (!array_key_exists('async', $options)) {
            $options['async'] = false;
        }
        if (!array_key_exists('asyncLoad', $options)) {
            $options['asyncLoad'] = false;
        }
        if (!array_key_exists('ifCondition', $options)) {
            $options['ifCondition'] = false;
        }
        if (!array_key_exists('priority', $options)) {
            $options['priority'] = 100;
        }

        $this->headerAssets[self::ASSET_TYPE_JS][] = [
            'path' => $options['path'],
            'async' => $options['async'],
            'asyncLoad' => $options['asyncLoad'],
            'ifCondition' => $options['ifCondition'],
            'priority' => $options['priority'],
        ];
    }

    public function addFooterCssPost($options)
    {
        if (!is_array($options)) {
            $options = [
                'path' => $options
            ];
        }
        $options['priority'] = 200;
        $this->addFooterCss($options);
    }

    public function addFooterCss($options)
    {
        if (!is_array($options)) {
            $options = [
                'path' => $options
            ];
        }

        if (!array_key_exists('asyncLoad', $options)) {
            $options['asyncLoad'] = false;
        }
        if (!array_key_exists('ifCondition', $options)) {
            $options['ifCondition'] = false;
        }
        if (!array_key_exists('priority', $options)) {
            $options['priority'] = 100;
        }

        $this->footerAssets[self::ASSET_TYPE_CSS][] = [
            'path' => $options['path'],
            'asyncLoad' => $options['asyncLoad'],
            'ifCondition' => $options['ifCondition'],
            'priority' => $options['priority'],
        ];
    }

    public function addFooterJsPost($options)
    {
        if (!is_array($options)) {
            $options = [
                'path' => $options
            ];
        }
        $options['priority'] = 200;
        $this->addFooterJs($options);
    }

    public function addFooterJs($options)
    {
        if (!is_array($options)) {
            $options = [
                'path' => $options
            ];
        }

        if (!array_key_exists('async', $options)) {
            $options['async'] = false;
        }
        if (!array_key_exists('asyncLoad', $options)) {
            $options['asyncLoad'] = false;
        }
        if (!array_key_exists('ifCondition', $options)) {
            $options['ifCondition'] = false;
        }
        if (!array_key_exists('priority', $options)) {
            $options['priority'] = 100;
        }

        $this->footerAssets[self::ASSET_TYPE_JS][] = [
            'path' => $options['path'],
            'async' => $options['async'],
            'asyncLoad' => $options['asyncLoad'],
            'ifCondition' => $options['ifCondition'],
            'priority' => $options['priority'],
        ];
    }

    private function isAsyncLoadJsExist()
    {
        foreach ($this->headerAssets[self::ASSET_TYPE_JS] as $asset) {
            if (array_key_exists('asyncLoad', $asset) && $asset['asyncLoad'] == true) {
                return true;
            }
        }
        return false;
    }

    private function isAsyncLoadCssExist()
    {
        foreach ($this->headerAssets[self::ASSET_TYPE_CSS] as $asset) {
            if (array_key_exists('asyncLoad', $asset) && $asset['asyncLoad'] == true) {
                return true;
            }
        }
        return false;
    }

    public function useCdnJQuery($version = '1.11.3')
    {
        $this->addFooterJs([
            'path' => "https://code.jquery.com/jquery-{$version}.min.js"
        ]);
    }

    public function useCdnFontAwesome($version = '4.4.0')
    {
        $this->addHeaderCss([
            'path' => "//maxcdn.bootstrapcdn.com/font-awesome/{$version}/css/font-awesome.min.css",
            'asyncLoad' => true
        ]);
    }

    public function asyncCss($files)
    {
        $result = "";
        if (!is_array($files)) {
            $files = [];
        }

        $result .= "<script>\n";
        foreach ($files as $file) {
            $result .= "   loadCSS(\"{$file}\");\n";
        }
        $result .= "</script>\n";

        foreach ($files as $file) {
            $result .= "<noscript><link rel=\"stylesheet\" href=\"{$file}\"></noscript>\n";
        }
        return $result;
    }

    public function asyncJs($files)
    {
        $result = "";
        if (!is_array($files)) {
            $files = [];
        }

        $result .= "<script>\n";
        foreach ($files as $file) {
            $result .= "   loadJS(\"{$file}\");\n";
        }
        $result .= "</script>\n";
        return $result;
    }

    private function flushCssCode()
    {
        return "<script>" . $this->getCssCode() . "</script>\n";
    }

    private function flushJsCode()
    {
        return "<script>" . $this->getJsCode() . "</script>\n";
    }

    private function getCssCode() {
        return 'function loadCSS(e,n,o,t){"use strict";var d=window.document.createElement("link"),i=n||window.document.getElementsByTagName("script")[0],r=window.document.styleSheets;return d.rel="stylesheet",d.href=e,d.media="only x",t&&(d.onload=t),i.parentNode.insertBefore(d,i),d.onloadcssdefined=function(e){for(var n,o=0;o<r.length;o++)r[o].href&&r[o].href===d.href&&(n=!0);n?e():setTimeout(function(){d.onloadcssdefined(e)})},d.onloadcssdefined(function(){d.media=o||"all"}),d};';
    }

    private function getJsCode() {
        return 'function loadJS(e,t){"use strict";var n=window.document.getElementsByTagName("script")[0],o=window.document.createElement("script");return o.src=e,o.async=!0,n.parentNode.insertBefore(o,n),t&&"function"==typeof t&&(o.onload=t),o};';
    }

} 