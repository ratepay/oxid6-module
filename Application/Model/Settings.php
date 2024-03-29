<?php

/**
 *
 * Copyright (c) Ratepay GmbH
 *
 *For the full copyright and license information, please view the LICENSE
 *file that was distributed with this source code.
 */

namespace pi\ratepay\Application\Model;

use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Model\BaseModel;
use pi\ratepay\Core\Utilities;

/**
 * Model class for pi_ratepay_settings table
 * @extends BaseModel
 */
class Settings extends BaseModel
{

    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = Settings::class;

    /**
     * Current country
     *
     * @var string
     */
    protected $_country = null;

    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->init('pi_ratepay_settings');
    }

    /**
     * CE Shop uses 'oxbaseshop' as default shopId
     *
     * set shopId to '1' if shopId is 'oxbaseshop'
     * @return int
     */
    public function setShopIdToOne($shopId)
    {
        if($shopId == 'oxbaseshop'){
            $shopId = 1;
        }

        return $shopId;
    }

    /**
     * Load either invoice or installment settings
     *
     * @param string $type 'invoice' | 'installment'
     * @return boolean
     */
    public function loadByType($type, $shopId, $country = null)
    {
        if ($country !== null) {
            $this->_setCountry($country);
        }

        //getting at least one field before lazy loading the object
        $this->_addField('oxid', 0);
        $whereClause = array(
            $this->getViewName() . ".shopid" => $shopId,
            $this->getViewName() . ".type" => strtolower($type),
            $this->getViewName() . ".country" => $this->getCountry()
        );
        $selectQuery = $this->buildSelectString($whereClause);

        $this->_isLoaded = $this->assignRecord($selectQuery);

        return $this->_isLoaded;
    }

    /**
     * Persist profile information into database
     *
     * @param $aActiveCombination
     * @param $aResult
     * @return void
     */
    public function piUpdateSettings($aActiveCombination, $aResult)
    {
        $oConfig = $this->getConfig();
        $sShopId = $oConfig->getShopId();
        if ($sShopId == 'oxbaseshop') {
            $sShopId = 1;
        }
        $sCountry = $aActiveCombination['country'];
        $sRequestMethod = $aActiveCombination['requestmethod'];
        $sMethod = $aActiveCombination['method'];
        $aConfigParams = $aActiveCombination['configparams'];
        $blActive = $oConfig->getConfigParam($aConfigParams['active']);
        $sProfileId = $oConfig->getConfigParam($aConfigParams['profileid']);
        $sSecurityCode = $oConfig->getConfigParam($aConfigParams['secret']);
        $blSandbox = $oConfig->getConfigParam($aConfigParams['sandbox']);
        $sUrl = ($sCountry == 'nl') ?
            Utilities::$_RATEPAY_PRIVACY_NOTICE_URL_NL :
            Utilities::$_RATEPAY_PRIVACY_NOTICE_URL_DACH;

        $this->loadByType($sRequestMethod, $sShopId, $sCountry);

        $this->pi_ratepay_settings__shopid = oxNew(Field::class, $sShopId);
        $this->pi_ratepay_settings__active = oxNew(Field::class, $blActive);
        $this->pi_ratepay_settings__country = oxNew(Field::class, strtoupper($sCountry));
        $this->pi_ratepay_settings__profile_id = oxNew(Field::class, $sProfileId);
        $this->pi_ratepay_settings__security_code = oxNew(Field::class, $sSecurityCode);
        $this->pi_ratepay_settings__sandbox = oxNew(Field::class, $blSandbox);
        $this->pi_ratepay_settings__url = oxNew(Field::class, $sUrl);
        $this->pi_ratepay_settings__type = oxNew(Field::class, $sRequestMethod);

        $aMerchantConfig = $aResult['merchantConfig'];
        $this->_piUpdateMerchantConfig($aMerchantConfig, $sRequestMethod);

        $blAddInstallmentData = (($sMethod == 'rate' || $sMethod == 'rate0') && $blActive);
        if ($blAddInstallmentData) {
            $aInstallmentConfig = $aResult['installmentConfig'];
            $this->_piUpdateInstallmentConfig($aInstallmentConfig);
        }

        $this->_piUpdateElv($sMethod, $sCountry);

        $this->save();
    }

    /**
     * Update data related to elv payment
     *
     * @param $sMethod
     * @param $sCountry
     * @return void
     */
    protected function _piUpdateElv($sMethod, $sCountry)
    {
        $oConfig = $this->getConfig();
        $iIbanOnly = 1;

        $blElvDE = ($sMethod == 'elv' && $sCountry == 'de');
        $blElv = ($sMethod == 'elv');

        if ($blElvDE) {
            $sElvRequestParam = 'rp_iban_only_' . $sMethod . '_' . $sCountry;
            $sIbanOnly = $oConfig->getRequestParameter($sElvRequestParam);
            $iIbanOnly = (int) ($sIbanOnly);
        }

        if ($blElv) {
            $this->pi_ratepay_settings__iban_only = oxNew(Field::class, $iIbanOnly);
        }
    }

    /**
     * Check if checkbox has been set to on for given parameter.
     *
     * @param string $parameter
     * @return int 0 for false and 1 for true
     */
    protected function _isParameterCheckedYes($parameter)
    {
        $checked = 0;
        if ($parameter != null && $parameter == 'yes') {
            $checked = 1;
        }
        return $checked;
    }

    /**
     * Adding merchant config to settings
     *
     * @param $aMerchantConfig
     * @param $sRequestMethod
     * @return void
     */
    protected function _piUpdateMerchantConfig($aMerchantConfig, $sRequestMethod)
    {
        // OX-28 : turn back method from 0% to normal, as data come from RP undistinctly named
        if ($sRequestMethod == 'installment0') {
            $sRequestMethod = 'installment';
        }

        $this->pi_ratepay_settings__limit_min = oxNew(Field::class, $aMerchantConfig['tx-limit-'.$sRequestMethod.'-min']);
        $this->pi_ratepay_settings__limit_max = oxNew(Field::class, $aMerchantConfig['tx-limit-'.$sRequestMethod.'-max']);
        $this->pi_ratepay_settings__limit_max_b2b = oxNew(Field::class, $aMerchantConfig['tx-limit-'.$sRequestMethod.'-max-b2b']);
        $this->pi_ratepay_settings__b2b = oxNew(Field::class, $this->_isParameterCheckedYes($aMerchantConfig['b2b-'.$sRequestMethod]));
        $this->pi_ratepay_settings__ala = oxNew(Field::class, $this->_isParameterCheckedYes($aMerchantConfig['delivery-address-'.$sRequestMethod]));
        $this->pi_ratepay_settings__dfp = oxNew(Field::class, $this->_isParameterCheckedYes($aMerchantConfig['eligibility-device-fingerprint']));
        $this->pi_ratepay_settings__currencies = oxNew(Field::class, $aMerchantConfig['currency']);
        $this->pi_ratepay_settings__delivery_countries = oxNew(Field::class, $aMerchantConfig['country-code-delivery']);

        if ($this->pi_ratepay_settings__b2b->value !== 0) {
            $this->pi_ratepay_settings__b2b = oxNew(Field::class, $aMerchantConfig['tx-limit-'.$sRequestMethod.'-max']);
        }
    }

    /**
     * Adding installment configuration
     *
     * @param $aInstallmentConfig
     * @return void
     */
    protected function _piUpdateInstallmentConfig($aInstallmentConfig)
    {
        $this->pi_ratepay_settings__month_allowed = oxNew(Field::class, "[" .$aInstallmentConfig['month-allowed']."]");
        $this->pi_ratepay_settings__min_rate = oxNew(Field::class, $aInstallmentConfig['rate-min-normal']);
        $this->pi_ratepay_settings__interest_rate = oxNew(Field::class, $aInstallmentConfig['interestrate-default']);
        $this->pi_ratepay_settings__payment_firstday = oxNew(Field::class, $aInstallmentConfig['valid-payment-firstdays']);
    }


    public function getCountry()
    {
        if ($this->_country === null) {
            $this->_country = Utilities::getCountry($this->getUser()->oxuser__oxcountryid->value);
        }
        return $this->_country;
    }

    private function _setCountry($country)
    {
        $this->_country = $country;
    }

    /**
     * Determines which settlement types are available in the connected RatePAY profile
     *
     * @return array
     */
    public function getAvailableSettlementTypes()
    {
        $sPaymentId = $this->getId();
        if (empty($sPaymentId)) {
            return array('debit', 'banktransfer', 'both'); // Settings not set yet
        }

        if ($this->pi_ratepay_settings__payment_firstday->value == '2,28') {
            return array('debit', 'banktransfer', 'both');
        } elseif ($this->pi_ratepay_settings__payment_firstday->value == '28') {
            return array('banktransfer');
        }
        return array('debit');
    }

    public function getSettlementType()
    {
        if (($this->pi_ratepay_settings__type->value != 'installment' && $this->pi_ratepay_settings__type->value != 'installment0') || !in_array($this->pi_ratepay_settings__country->value, array('DE', 'AT'))) {
            return false;
        }

        if ($this->pi_ratepay_settings__payment_firstday->value == '2,28') {
            return 'both';
        } elseif ($this->pi_ratepay_settings__payment_firstday->value == '28') {
            return 'banktransfer';
        }
        return 'debit';
    }
}
