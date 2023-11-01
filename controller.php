<?php

namespace Concrete\Package\PricingSlider;

use Concrete\Core\Package\Package;

class Controller extends Package
{
    protected $pkgHandle = 'pricing_slider';
    protected $pkgVersion = '1.0.3';
    protected $appVersionRequired = '9.0.0';
    
    public function getPackageDescription()
    {
        return t('Add support to a pricing slider to your site.');
    }

    public function getPackageName()
    {
        return t('Pricing Slider');
    }

    public function install()
    {
        $pkg = parent::install();
        $this->installContentFile("data.xml");
        return $pkg;
    }

    public function upgrade()
    {
        parent::upgrade();
        $this->installContentFile("data.xml");
    }
}