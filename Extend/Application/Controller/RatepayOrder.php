<?php

/**
 *
 * Copyright (c) Ratepay GmbH
 *
 *For the full copyright and license information, please view the LICENSE
 *file that was distributed with this source code.
 */

namespace pi\ratepay\Extend\Application\Controller;

use OxidEsales\Eshop\Core\Registry;

/**
 * {@inheritdoc}
 *
 * Additionally sends RatePAY PAYMENT_REQUEST and sets RatePAY payment specific informations in db and session.
 *
 * @package PayIntelligent_RatePAY
 * @extends order
 */
class RatepayOrder extends RatepayOrder_parent
{
    public function init()
    {
        parent::init();

        $this->_setDeviceFingerPrint();
    }


    /**
     * Check if this is a OXID 4.6.x Shop.
     * @return bool
     */
    public function piIsFourPointSixShop()
    {
        return substr(Registry::getConfig()->getVersion(), 0, 3) === '4.6';
    }

    /**
     * Returns next order step. If ordering was sucessfull - returns string "thankyou" (possible
     * additional parameters), otherwise - returns string "payment" with additional
     * error parameters.
     *
     * @param integer $iSuccess status code
     *
     * @return  string  $sNextStep  partial parameter url for next step
     */
    protected function _getNextStep($iSuccess)
    {
        $nextStep = parent::_getNextStep($iSuccess);

        /**
         * OX-44 clean session payment data as the order got placed
         */
        if(substr($nextStep, 0, 8) == "thankyou"){
            $this->cleanSessionPaymentData();
        }

        return $nextStep;
    }

    /**
     * OX-44 clean ratepay session data
     */
    protected function cleanSessionPaymentData()
    {
        $variablesToClean = [
            'basketAmount',
            'bankOwner',
            'paymentid'
        ];
        $sessionVariables = array_keys($_SESSION);
        $sessionVariables = array_filter($sessionVariables, function($key) {
            return preg_match('/^pi_ratepay.*/', $key) == 1;
        });

        $session = (Registry::getSession());
        $variablesToClean = array_merge($variablesToClean, $sessionVariables);

        foreach ($variablesToClean as $key) {
            if($session->hasVariable($key)) {
                $session->deleteVariable($key);
            }
        }
    }

    /**
     * Creates a device fingerprint token if not exists
     */
    private function _setDeviceFingerPrint() {
        $DeviceFingerprintToken     = $this->getSession()->getVariable('pi_ratepay_dfp_token');
        $DeviceFingerprintSnippetId = $this->getConfig()->getConfigParam('sRPDeviceFingerprintSnippetId');
        if (empty($DeviceFingerprintSnippetId)) {
            $DeviceFingerprintSnippetId = 'C9rKgOt'; // default value, so that there is always a device fingerprint
        }

        if (empty($DeviceFingerprintToken)) {
            $timestamp = microtime();
            $sessionId = $this->getSession()->getId();
            $DeviceFingerprintToken = md5($sessionId . "_" . $timestamp);

            $this->getSession()->setVariable('pi_ratepay_dfp_token', $DeviceFingerprintToken);
        }

        $this->addTplParam('pi_ratepay_dfp_token', $DeviceFingerprintToken);
        $this->addTplParam('pi_ratepay_dfp_snippet_id', $DeviceFingerprintSnippetId);
    }
}

