<?php

namespace pi\ratepay\Extend\Core;

/**
 * Class pi\ratepay\Extend\Core\ShopControl
 *
 * extends OXID ShopControl core class to enable loading a custom autoloader
 * see details in code below
 */
class ShopControl extends \OxidEsales\Eshop\Core\ShopControl
{
    public function start($sClass = null, $sFunction = null, $aParams = null, $aViewsChain = null)
    {
        /**
         * OXID-169
         * If the classes using backslash namespace format are not found
         * this might be due to using Windows system, handling filepath differently.
         * Then we call a specific class autoloader for those classes
         */
        if (!class_exists('RatePAY\RequestBuilder')) {
            require __DIR__ . '/../../autoloader.php';
            spl_autoload_register('ratepayAutoload');
        }

        return parent::start($sClass, $sFunction, $aParams, $aViewsChain);
    }
}
