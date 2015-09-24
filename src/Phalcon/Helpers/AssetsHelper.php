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
        if ($this->asyncLoadRendered) {
            return true;
        }

        if ($this->isAsyncLoadCssExist()) {
            $this->flushCssCode();
        }

        if ($this->isAsyncLoadJsExist()) {
            $this->flushJsCode();
        }

        $this->asyncLoadRendered = true;
        return true;
    }

    public function renderInHeader()
    {
        $this->renderAsyncLoad();

        echo $this->renderAssets($this->headerAssets);
    }

    public function renderInFooter()
    {
        $this->renderAsyncLoad();

        echo $this->renderAssets($this->footerAssets);

        if (count($this->scripts)) {
            echo "<script>\n" . implode("\n\n", $this->scripts) . "</script>";
        }
    }

    private function renderAssets($assets)
    {
        $result = '';

        $css = $assets[self::ASSET_TYPE_CSS];
        $js = $assets[self::ASSET_TYPE_JS];

        $asyncLoadListCss = [];
        foreach ($css as $option) {
            if ($option['asyncLoad'] == true) {
                $asyncLoadListCss[] = $option['path'];
            }
        }
        if (count($asyncLoadListCss)) {
            $this->asyncCss($asyncLoadListCss);
        }

        $asyncLoadListJs = [];
        foreach ($js as $option) {
            if ($option['asyncLoad'] == true) {
                $asyncLoadListJs[] = $option['path'];
            }
        }
        if (count($asyncLoadListJs)) {
            $this->asyncJs($asyncLoadListJs);
        }

        foreach ($css as $option) {
            if ($option['asyncLoad'] == true) {
            } else {
                $result .= "<link href=\"{$option['path']}\" rel=\"stylesheet\" />\n";
            }
        }

        foreach ($js as $option) {
            if ($option['async'] == true) {
                $result .= "<script src=\"{$option['path']}\" async></script>\n";
            } elseif ($option['asyncLoad'] == true) {
            } else {
                $result .= "<script src=\"{$option['path']}\"></script>\n";
            }
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

        $this->headerAssets[self::ASSET_TYPE_CSS][] = [
            'path' => $options['path'],
            'asyncLoad' => $options['asyncLoad']
        ];
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

        $this->headerAssets[self::ASSET_TYPE_JS][] = [
            'path' => $options['path'],
            'async' => $options['async'],
            'asyncLoad' => $options['asyncLoad']
        ];
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

        $this->footerAssets[self::ASSET_TYPE_CSS][] = [
            'path' => $options['path'],
            'asyncLoad' => $options['asyncLoad']
        ];
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

        $this->footerAssets[self::ASSET_TYPE_JS][] = [
            'path' => $options['path'],
            'async' => $options['async'],
            'asyncLoad' => $options['asyncLoad']
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

    public function useCdnForJQuery($version = '1.11.3')
    {
        $this->addFooterJs([
            'path' => "https://code.jquery.com/jquery-{$version}.min.js"
        ]);
    }

    public function useCdnForFontAwesome($version = '4.4.0')
    {
        $this->addHeaderCss([
            'path' => "//maxcdn.bootstrapcdn.com/font-awesome/{$version}/css/font-awesome.min.css",
            'asyncLoad' => true
        ]);
    }

    public function asyncCss($files)
    {
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