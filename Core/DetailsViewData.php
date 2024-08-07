<?php

/**
 *
 * Copyright (c) Ratepay GmbH
 *
 *For the full copyright and license information, please view the LICENSE
 *file that was distributed with this source code.
 */

namespace pi\ratepay\Core;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Model\BaseModel;

/**
 * Helper Class to generate RatePAY order data.
 */
class DetailsViewData extends BaseModel
{
    /**
     * oxid of order
     * @var string
     */
    private $_orderId;

    /**
     * Order values
     * @var array|null 
     */
    protected $_orderValues = null;

    /**
     * Name of order details table
     * @var string
     */
    private $pi_ratepay_order_details = 'pi_ratepay_order_details';

    /**
     * Class constructor
     * @param string $orderId oxid of order
     */
    public function __construct($orderId)
    {
        $this->_orderId = $orderId;
    }

    /**
     * Gets all articles with additional informations
     *
     * @param bool $blIsDisplayList
     * @return array
     */
    public function getPreparedOrderArticles($blIsDisplayList = false)
    {
        $articleList = $this->_piGetOrderArticleList();
        $articleList = $this->_piAddSpecialCosts($articleList, 'oxwrapping', 'Wrapping Cost');
        $articleList = $this->_piAddSpecialCosts($articleList, 'oxgiftcard', 'Giftcard Cost');
        $articleList = $this->_piAddSpecialCosts($articleList, 'oxpayment', 'Payment Costs');
        $articleList = $this->_piAddSpecialCosts($articleList, 'oxdelivery', 'Delivery Costs');
        $articleList = $this->_piAddSpecialCosts($articleList, 'oxtsprotection', 'TS Protection Cost');
        $articleList = $this->_piAddDiscounts($articleList);
        $articleList = $this->_piAddVouchers($articleList, $blIsDisplayList);
        $articleList = $this->_piAddCredit($articleList);

        return $articleList;
    }

    protected function _getDescriptionAddition($sPersParam)
    {
        $sDescriptionAddition = false;
        if (!empty($sPersParam)) {
            $aPersParams = unserialize($sPersParam);
            if (is_array($aPersParams) && !empty($aPersParams)) {
                if (count($aPersParams) == 1 && isset($aPersParams['details'])) {
                    $sDescriptionAddition = $aPersParams['details'];
                } else {
                    $sDescriptionAddition = '';
                    foreach ($aPersParams as $sKey => $sValue) {
                        $sDescriptionAddition .= $sKey.'='.$sValue.';';
                    }
                }
            }
        }
        return $sDescriptionAddition;
    }

    /**
     * Initial method for generating an article list
     *
     * @return array
     */
    protected function _piGetOrderArticleList()
    {
        $oDb = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
        $articleList = array();

        # Get order articles
        $articlesSql = "SELECT
              oo.OXCURRENCY,
              oa.OXID,
              oa.OXARTID,
              oa.OXARTNUM,
              oa.OXVAT,
              oa.OXBPRICE,
              oa.OXNPRICE,
              oa.OXTITLE,
              oa.OXNETPRICE,
              oa.OXAMOUNT,
              oa.OXPERSPARAM,
              prrod.ORDERED,
              prrod.CANCELLED,
              prrod.RETURNED,
              prrod.SHIPPED,
              prrod.UNIQUE_ARTICLE_NUMBER,
              if(oa.OXSELVARIANT != '',concat(oa.OXTITLE,', ',oa.OXSELVARIANT),oa.OXTITLE) as TITLE
            FROM
                `oxorder` AS oo
            INNER JOIN
                `oxorderarticles` AS oa ON oa.oxorderid = oo.oxid
            INNER JOIN
                (SELECT * FROM ".$this->pi_ratepay_order_details." WHERE ORDER_NUMBER = '{$this->_orderId}') AS prrod
            WHERE
                oo.oxid = '{$this->_orderId}' AND
               oa.oxid = prrod.UNIQUE_ARTICLE_NUMBER
            GROUP BY prrod.oxid";
        $aRows = $oDb->getAll($articlesSql);

        foreach ($aRows as $aRow) {
            $iAmount = $aRow['ORDERED'] - $aRow['SHIPPED'] - $aRow['CANCELLED'];
            $dTotal = $aRow['ORDERED'] - $aRow['RETURNED'] - $aRow['CANCELLED'];

            $listEntry['oxid'] = $aRow['OXID'];
            $listEntry['artid'] = $aRow['OXARTID'];
            $listEntry['arthash'] = $aRow['UNIQUE_ARTICLE_NUMBER'];
            $listEntry['artnum'] = $aRow['OXARTNUM'];
            $listEntry['title'] = $aRow['TITLE'];
            $listEntry['oxtitle'] = $aRow['OXTITLE'];
            $listEntry['vat'] = $aRow['OXVAT'];
            $listEntry['unitprice'] = (float) $aRow['OXNPRICE'];
            $listEntry['amount'] = $iAmount;
            $listEntry['ordered'] = $aRow['ORDERED'];
            $listEntry['shipped'] = $aRow['SHIPPED'];
            $listEntry['returned'] = $aRow['RETURNED'];
            $listEntry['cancelled'] = $aRow['CANCELLED'];
            $listEntry['currency'] = $aRow['OXCURRENCY'];
            $listEntry['bruttoprice'] = (float) $aRow['OXBPRICE'];
            $listEntry['unique_article_number'] = $aRow['UNIQUE_ARTICLE_NUMBER'];
            $listEntry['description_addition'] = $this->_getDescriptionAddition($aRow['OXPERSPARAM']);

            if ($dTotal > 0) {
                $listEntry['totalprice'] = (float)
                    $aRow['OXBPRICE'] * (
                        $listEntry['ordered'] - 
                        $listEntry['returned'] - 
                        $listEntry['cancelled']
                    );
            } else {
                $listEntry['totalprice'] = 0;
            }

            $articleList[] = $listEntry;
        }

        return $articleList;
    }

    /**
     * Adding special costs to article list
     *
     * @param $articleList
     * @param $ident
     * @param $title
     * @return array
     */
    protected function _piAddSpecialCosts($articleList, $ident, $title)
    {
        $aRow = $this->_piGetOrderSpecialCostsQuery($ident);

        if ($aRow['PRICE'] > 0) {
            $listEntry['oxid'] = "";
            $listEntry['artid'] = $ident;
            $listEntry['arthash'] = md5($aRow['UNIQUE_ARTICLE_NUMBER']);
            $listEntry['artnum'] = $ident;
            $listEntry['title'] = $title;
            $listEntry['oxtitle'] = $title;
            $listEntry['vat'] = (float) $aRow['VAT'];
            $listEntry['unitprice'] = (float) $aRow['PRICE'];
            $listEntry['amount'] = 1 - $aRow['SHIPPED'] - $aRow['CANCELLED'];
            $listEntry['ordered'] = $aRow['ORDERED'];
            $listEntry['shipped'] = $aRow['SHIPPED'];
            $listEntry['returned'] = $aRow['RETURNED'];
            $listEntry['cancelled'] = $aRow['CANCELLED'];
            $listEntry['currency'] = $aRow['oxcurrency'];
            $listEntry['unique_article_number'] = $aRow['unique_article_number'];
            $listEntry['description_addition'] = false;

            $blHasTotal = (
                ($aRow['ORDERED'] - $aRow['RETURNED'] - $aRow['CANCELLED']) > 0
            );

            if ($blHasTotal) {
                $dTotal =
                    (float) $aRow['PRICE'] +
                    ((float) $aRow['PRICE'] *
                        round((float) $aRow['VAT']) / 100);

                $listEntry['totalprice'] = $dTotal;
            } else {
                $listEntry['totalprice'] = 0;
            }

            $articleList[] = $listEntry;
        }

        return $articleList;
    }

    /**
     * Add discounts to article list
     * 
     * @param $articleList
     * @return array
     */
    protected function _piAddDiscounts($articleList)
    {
        $oDb = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);

        $sQuery = "
            SELECT
                oo.oxcurrency,
                od.oxid AS ARTID,
                od.oxtitle AS TITLE,
                oo.oxdiscount AS PRICE,
                prrod.ordered AS ORDERED,
                prrod.cancelled AS CANCELLED,
                prrod.returned AS RETURNED,
                prrod.shipped AS SHIPPED,
                prrod.unique_article_number
            FROM
                `oxorder` oo,
                `oxdiscount` od,
                " . $this->pi_ratepay_order_details . " prrod
            WHERE
                prrod.order_number = '" . $this->_orderId . "'
                AND prrod.article_number = od.oxid
                AND oo.oxid = prrod.order_number";

        $aRow = $oDb->getRow($sQuery);

        if ($aRow['PRICE'] != 0) {

            $listEntry['oxid'] = "";
            $listEntry['artid'] = $aRow['ARTID'];
            $listEntry['arthash'] = md5($aRow['unique_article_number']);
            $listEntry['artnum'] = "discount";
            $listEntry['title'] = $aRow['TITLE'];
            $listEntry['oxtitle'] = $aRow['TITLE'];
            $listEntry['vat'] = "0";
            $listEntry['unitprice'] = (float) $aRow['PRICE'];
            $listEntry['amount'] = 1 - $aRow['SHIPPED'] - $aRow['CANCELLED'];
            $listEntry['ordered'] = $aRow['ORDERED'];
            $listEntry['shipped'] = $aRow['SHIPPED'];
            $listEntry['returned'] = $aRow['RETURNED'];
            $listEntry['cancelled'] = $aRow['CANCELLED'];
            $listEntry['currency'] = $aRow['oxcurrency'];
            $listEntry['unique_article_number'] = $aRow['unique_article_number'];
            $listEntry['description_addition'] = false;

            $blHasTotal = (
                ($aRow['ORDERED'] - $aRow['RETURNED'] - $aRow['CANCELLED']) > 0
            );

            if ($blHasTotal) {
                $dTotal =
                    (float) $aRow['PRICE'] +
                    ((float) $aRow['PRICE'] *
                        round((float) $aRow['VAT']) / 100);

                $listEntry['totalprice'] = $dTotal;
            } else {
                $listEntry['totalprice'] = 0;
            }

            $articleList[] = $listEntry;
        }

        return $articleList;
    }

    /**
     * Add vouchers to article list
     *
     * @param array $articleList
     * @param bool $blIsDisplayList
     * @return array
     */
    protected function _piAddVouchers($articleList, $blIsDisplayList = false)
    {
        $oDb = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);

        $sQuery = "
            SELECT
                oo.oxcurrency,
                ov.oxdiscount AS price,
                ov.oxdiscount as totaldiscount,
                prrod.article_number AS artnr,
                ov.oxvouchernr AS title,
                prrod.ORDERED,
                prrod.CANCELLED,
                prrod.RETURNED,
                prrod.SHIPPED,
                prrod.unique_article_number,
                ovs.OXSERIENR as seriesTitle,
                ovs.OXSERIEDESCRIPTION as seriesDescription
            FROM
                `oxorder` oo,
                `oxvouchers` ov,
                " . $this->pi_ratepay_order_details . " prrod,
                oxvoucherseries ovs
            WHERE
                prrod.order_number = '" . $this->_orderId . "' AND 
                ov.oxorderid = prrod.order_number AND 
                prrod.article_number = ov.oxid AND 
                ovs.oxid = ov.OXVOUCHERSERIEID AND 
                oo.oxid = prrod.order_number AND
                ov.oxvoucherserieid != 'pi_ratepay_voucher'";

        $aRows = $oDb->getAll($sQuery);

        $dTotalprice = 0;

        $blIsNettoMode = false;
        $dVoucherVat = $this->getConfig()->getConfigParam('dDefaultVAT');
        $aOrderValues = $this->_piGetOrderValues();
        if (count($aOrderValues) > 0) {
            $sOrderCountryId = $aOrderValues[0]['OXBILLCOUNTRYID'];
            $oOrderCountry = oxNew('oxcountry');
            if ($oOrderCountry->load($sOrderCountryId)) {
                if ($oOrderCountry->oxcountry__oxvatstatus->value == 0) {
                    $dVoucherVat = 0;
                };
            }

            $blIsNettoMode = (bool) $aOrderValues[0]['OXISNETTOMODE'];
        }

        $dSum = 0;
        for ($i = 0; $i < count($aRows); $i++) {
            $aRow = $aRows[$i];
            if ($aRow['price'] != 0) {
                $dPrice = $blIsNettoMode ? (float)$aRow['price'] : (float)$aRow['price'] / ((100+$dVoucherVat)/100);

                $listEntry['oxid'] = "";
                $listEntry['artid'] = $aRow['artnr'];
                $listEntry['arthash'] = md5($aRow['artnr']);
                $listEntry['artnum'] = 'voucher_' . $aRow['title'];
                $listEntry['title'] = $aRow['seriesTitle'];
                $listEntry['oxtitle'] = $aRow['seriesTitle'];
                $listEntry['vat'] = $dVoucherVat;
                $listEntry['unitprice'] = $dPrice;
                $listEntry['amount'] = 1 - $aRow['SHIPPED'] - $aRow['CANCELLED'];
                $listEntry['ordered'] = $aRow['ORDERED'];
                $listEntry['shipped'] = $aRow['SHIPPED'];
                $listEntry['returned'] = $aRow['RETURNED'];
                $listEntry['cancelled'] = $aRow['CANCELLED'];
                $listEntry['currency'] = $aRow['oxcurrency'];
                $listEntry['unique_article_number'] = $aRow['unique_article_number'];
                $listEntry['description_addition'] = false;

                $blHasTotal = (
                    ($aRow['ORDERED'] - $aRow['RETURNED'] - $aRow['CANCELLED']) > 0
                );

                if ($blHasTotal) {
                    $dTotal =
                        $dPrice +
                        ($dPrice *
                            round((float)$dVoucherVat) / 100);

                    $listEntry['totalprice'] = $dTotal;
                } else {
                    $listEntry['totalprice'] = 0;
                }

                $dSum += $dPrice;
                $dTotalprice += $listEntry['totalprice'];

                if ($blIsNettoMode && $blIsDisplayList === false && $blHasTotal && count($aRows) == ($i + 1) && $dSum != (float)$aRow['totaldiscount']) { // is last voucher
                    // compensation for rounding discrepancies
                    $dDiff = (float)$dTotalprice - $dSum;
                    $listEntry['unitprice'] += $dDiff;
                    $listEntry['totalprice'] += $dDiff;
                }

                $articleList[] = $listEntry;
            }
        }

        return $articleList;
    }

    /**
     * Add credit to articlelist
     *
     * @param $articleList
     * @return array
     */
    protected function _piAddCredit($articleList)
    {
        $oDb = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);

        $sQuery = "
            SELECT
                oo.oxcurrency,
                ov.oxdiscount AS price,
                prrod.article_number AS artnr,
                ov.oxvouchernr AS title,
                prrod.ORDERED,
                prrod.CANCELLED,
                prrod.RETURNED,
                prrod.unique_article_number,
                prrod.SHIPPED
            FROM
                `oxorder` oo,
                `oxvouchers` ov,
                " . $this->pi_ratepay_order_details . " prrod
            WHERE
            prrod.order_number = '" . $this->_orderId . "'
            AND ov.oxorderid = prrod.order_number
            AND ov.oxvoucherserieid = 'pi_ratepay_voucher'
            AND prrod.article_number = ov.oxid
            AND oo.oxid = prrod.order_number";

        $aRows = $oDb->getAll($sQuery);

        $creditVat = isset($aRow['VAT']) ? (float) $aRow['VAT'] : 0;

        foreach ($aRows as $aRow) {
            if ($aRow['price'] != 0) {
                $listEntry['oxid'] = "";
                $listEntry['artid'] = $aRow['artnr'];
                $listEntry['arthash'] = md5($aRow['artnr']);
                $listEntry['artnum'] = 'voucher_' . $aRow['title'];
                $listEntry['title'] = $aRow['title'];
                $listEntry['oxtitle'] = $aRow['title'];
                $listEntry['vat'] = $creditVat;
                $listEntry['unitprice'] = (float)$aRow['price'];
                $listEntry['amount'] = 1 - $aRow['SHIPPED'] - $aRow['CANCELLED'];
                $listEntry['ordered'] = $aRow['ORDERED'];
                $listEntry['shipped'] = $aRow['SHIPPED'];
                $listEntry['returned'] = $aRow['RETURNED'];
                $listEntry['cancelled'] = $aRow['CANCELLED'];
                $listEntry['currency'] = $aRow['oxcurrency'];
                $listEntry['unique_article_number'] = $aRow['unique_article_number'];
                $listEntry['description_addition'] = false;

                if (($aRow['ORDERED'] - $aRow['RETURNED'] - $aRow['CANCELLED']) > 0) {
                    $listEntry['totalprice'] = (float)$aRow['price'] + ((float)$aRow['price'] * round($creditVat) / 100);
                } else {
                    $listEntry['totalprice'] = 0;
                }

                $articleList[] = $listEntry;
            }
        }

        return $articleList;
    }

    /**
     * Returns special costs
     *
     * @param $sIdent
     * @return mixed
     */
    protected function _piGetOrderSpecialCostsQuery($sIdent)
    {
        $oDb = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);

        $sQuery = "
            SELECT 
                oo.oxcurrency, 
                prrod.* 
            FROM 
                {$this->pi_ratepay_order_details} prrod, oxorder oo
            WHERE
                prrod.order_number = '{$this->_orderId}' AND 
                prrod.article_number = '{$sIdent}' AND 
                oo.oxid = prrod.order_number";

        $aRow = $oDb->getRow($sQuery);

        return $aRow;
    }

    /**
     * Returns order informations
     * 
     * @return array|null
     */
    protected function _piGetOrderValues() 
    {
        if ($this->_orderValues === null) {
            $oDb = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
            $orderId = $this->_orderId;
            $orderSql = "SELECT * from `oxorder` where oxid='{$orderId}'";
            $this->_orderValues = $oDb->getAll($orderSql);
        }
        
        return $this->_orderValues;
    }
}
