<?php

namespace Sb\Phalcon\Helpers;

class ViewHelper
{

    private static $titleParts = array();

    private $di = null;
    private $partialView = null;

    private $jsAssets = null;
    private $cssAssets = null;

    public function __construct($di)
    {
        $this->di = $di;

        //$this->jsAssets = new \Optimization\Assets\JS();
        //$this->cssAssets = new \Optimization\Assets\CSS();
    }

    public function title($text = null)
    {
        if ($text) {
            array_push(self::$titleParts, $text);
        } else {
            echo implode(array_reverse(self::$titleParts), " / ");
        }
    }

    public function partial($template, $params = array())
    {
        if (is_null($this->partialView)) {
            $applicationConfig = $this->di->get('applicationConfig');
            $this->partialView = new \Phalcon\Mvc\View();
            $this->partialView->setViewsDir($applicationConfig['viewsDir']);
            $this->partialView->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
            $this->partialView->setVar('url', new UrlHelper($this->di));
        }

        $this->partialView->setVars($params );

        list($action, $controller) = explode("/", $template);
        $this->partialView->start();
        $this->partialView->render($action, $controller);
        $this->partialView->finish();

        echo $this->partialView->getContent();
    }

	public function imageSize($width, $height, $newWidth = null, $newHeight = null)
	{
        $newWidth = round($height * $newWidth / $width);
        return $newWidth;
	}

    public function imageResize($name, $width = null, $height = null, $mode = 0)
	{
        $host = $_SERVER['HTTP_HOST'];
        $hostParts = explode(".", $host);
        $path = '//static.' . $hostParts[count($hostParts)-2] . '.' . $hostParts[count($hostParts)-1] . '/';

        if (is_null($width) && is_null($height)) {
            $path .= 'upload/' . $name;
        } else {
            $path .= "_img/{$width}/{$height}/{$mode}/" . $name;
        }

        return $path;
    }

    public function imageResizeIdn($name, $width = null, $height = null, $mode = 0, $host = null)
	{
        $name = strtolower($name);
        if (!$host) {
            $host = $_SERVER['HTTP_HOST'];
        }
        $hostParts = explode(".", $host);
        $path = '//static.' . $hostParts[count($hostParts)-2] . '.' . $hostParts[count($hostParts)-1] . '/idn/';

        if (is_null($width) && is_null($height)) {
            $path .= $name;
        } else {
            $path .= "_img/{$width}/{$height}/{$mode}/" . $name;
        }

        return $path;
    }

    public function js($group, $theme = 'default')
    {
        return $this->jsAssets->javascripts($group, $theme);
    }

    public function jsjQuery()
    {
        return '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>' . PHP_EOL;
    }

    public function jsExt($url)
    {
        return '<script src="' . $url . '"></script>' . PHP_EOL;
    }

    public function css($group, $theme = 'default')
    {
        return $this->cssAssets->stylesheets($group, $theme);
    }
    
    public function cssExt($url)
    {
        return '<link rel="stylesheet" href="' . $url . '" media="screen" />' . PHP_EOL;
    }
	
	public function phone($phone)
    {
        $phone = '7' . $phone;
        $phone = preg_replace('|[^0-9]|is','',$phone);
        $phone = '+' . substr($phone,0,1)." (".substr($phone,1,3).") ".substr($phone,4,3)."-".substr($phone,7,2)."-".substr($phone,9,2);
        return $phone;
    }

    public function nl2br($text)
    {
        return str_replace("\n","<br/>", $text);
    }

    public function lower($text)
    {
        return mb_strtolower($text, "UTF-8");
    }

    public function email($address)
    {
        $extra = '';
        $text = $address;

        preg_match('!^(.*)(\?.*)$!',$address,$match);
        $address_encode = '';
        for ($x=0; $x < strlen($address); $x++) {
            if(preg_match('!\w!',$address[$x])) {
                $address_encode .= '%' . bin2hex($address[$x]);
            } else {
                $address_encode .= $address[$x];
            }
        }
        $text_encode = '';
        for ($x=0; $x < strlen($text); $x++) {
            $text_encode .= '&#x' . bin2hex($text[$x]).';';
        }

        $mailto = "&#109;&#97;&#105;&#108;&#116;&#111;&#58;";
        return '<a href="'.$mailto.$address_encode.'" '.$extra.'>'.$text_encode.'</a>';
    }

    public function escape($text)
    {
        return htmlspecialchars($text);
    }

    public function distance($distanceInMetr)
    {
        if ($distanceInMetr < 1000) {
            return $distanceInMetr . ' м.';
        }

        return round($distanceInMetr / 1000, 1) . ' км.';
    }
}
