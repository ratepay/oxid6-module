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
        return parent::start($sClass, $sFunction, $aParams, $aViewsChain);
    }
}
