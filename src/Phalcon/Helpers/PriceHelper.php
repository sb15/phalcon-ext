<?php

namespace Sb\Phalcon\Helpers;

class PriceHelper
{
    const SERVICE_NAME = 'price-helper';

    /**
     * @var \Phalcon\DI\FactoryDefault
     */
    private $di = null;

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function format($price, $decimals = 0, $decimalsSeparator = ',', $thousandsSeparator = ' ')
    {
        return number_format($price, $decimals, $decimalsSeparator, $thousandsSeparator);
    }
}