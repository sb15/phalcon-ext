<?php

namespace Sb\Phalcon\Helpers;

class ViewHelper
{
    const SERVICE_NAME = 'view-helper';

    /**
     * @var \Phalcon\DI\FactoryDefault 
     */
    private $di = null;

    private $urlHelper = null;
    private $seoHelper = null;
    private $breadcrumbHelper = null;
    private $assetsHelper = null;
    private $phoneHelper = null;
    private $priceHelper = null;

    public function __construct($di)
    {
        $this->di = $di;
    }

    /**
     * @return UrlHelper
     */
    public function url()
    {
        if (is_null($this->urlHelper)) {
            $this->urlHelper = new UrlHelper($this->di);
        }
        return $this->urlHelper;
    }

    /**
     * @return SeoHelper
     */
    public function seo()
    {
        if (is_null($this->seoHelper)) {
            $this->seoHelper = new SeoHelper($this->di);
        }
        return $this->seoHelper;
    }

    /**
     * @return BreadcrumbHelper
     */
    public function breadcrumb()
    {
        if (is_null($this->breadcrumbHelper)) {
            $this->breadcrumbHelper = new BreadcrumbHelper($this->di);
        }
        return $this->breadcrumbHelper;
    }

    /**
     * @return AssetsHelper
     */
    public function assets()
    {
        if (is_null($this->assetsHelper)) {
            $this->assetsHelper = new AssetsHelper($this->di);
        }
        return $this->assetsHelper;
    }

    /**
     * @return PhoneHelper
     */
    public function phone()
    {
        if (is_null($this->phoneHelper)) {
            $this->phoneHelper = new PhoneHelper($this->di);
        }
        return $this->phoneHelper;
    }

    /**
     * @return PriceHelper
     */
    public function price()
    {
        if (is_null($this->priceHelper)) {
            $this->priceHelper = new PriceHelper($this->di);
        }
        return $this->priceHelper;
    }

}
