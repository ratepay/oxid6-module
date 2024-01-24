<!--
*
* Copyright (c) Ratepay GmbH
*
*For the full copyright and license information, please view the LICENSE
*file that was distributed with this source code.
*-->
[{if $sPaymentID == "pi_ratepay_rate0"}]
[{assign var="dynvalue" value=$oView->getDynValue()}]
<dl>
    <dt>
        <input id="payment_[{$sPaymentID}]" type="radio" onclick="piCalculator(); autoLoadPiCalculator('pi_ratepay_rate0');" name="paymentid" value="[{$sPaymentID}]" [{if $oView->getCheckedPaymentId() == $paymentmethod->oxpayments__oxid->value}]checked[{/if}] style="position:relative;">
        <label for="payment_[{$sPaymentID}]"><b>
                [{$paymentmethod->oxpayments__oxdesc->value}]
        </b></label>
    </dt>
    <dd class="[{if $oView->getCheckedPaymentId() == $paymentmethod->oxpayments__oxid->value}]activePayment[{/if}]" [{if $oView->getCheckedPaymentId() != $paymentmethod->oxpayments__oxid->value}]style="display:none"[{/if}]>
        [{if $pi_ratepay_rate0_sandbox_notification == 1 }]
        <div id="sandbox_notification[{$sPaymentID}]" style="background: yellow; color: black; border: 3px dashed red; font-weight: bold; text-align: center; font-size:14px; padding-top: 10px; ">
            <p>
                [{oxmultilang ident="PI_RATEPAY_RATE0_VIEW_SANDBOX_NOTIFICATION"}]
            </p>
        </div>
        [{/if}]
        <div>
            [{ oxmultilang ident="PI_RATEPAY_POLICY" }]
        </div>

        <div class="form" style="margin-top: 15px">
            [{if isset($pi_ratepay_rate0_fon_check)}]
            <p style="margin-bottom: 15px;">
                <label>[{oxmultilang ident="PI_RATEPAY_RATE0_VIEW_PAYMENT_FON"}]</label>
                <input name='pi_ratepay_rate0_fon' type='text' value='' size='37' class='form-control'/>
            </p>
            [{/if}]
            [{if isset($pi_ratepay_rate0_birthdate_check)}]
            <p style="margin-bottom: 15px;">
                <label>[{oxmultilang ident="PI_RATEPAY_RATE0_VIEW_PAYMENT_BIRTHDATE"}]</label>
                <input name='pi_ratepay_rate0_birthdate_day' maxlength='2' type='text' value='' data-fieldsize='small' class='form-control'/>
                <input name='pi_ratepay_rate0_birthdate_month' maxlength='2' type='text' value='' data-fieldsize='small' class='form-control'/>
                <input name='pi_ratepay_rate0_birthdate_year' maxlength='4' type='text' value='' data-fieldsize='small' class='form-control'/>
                <span class='note'>[{oxmultilang ident="PI_RATEPAY_RATE0_VIEW_PAYMENT_BIRTHDATE_FORMAT"}]</span>
            </p>
            [{/if}]
            [{if isset($pi_ratepay_rate0_company_check)}]
            <p style="margin-bottom: 15px;">
                <label>[{oxmultilang ident="PI_RATEPAY_RATE0_VIEW_PAYMENT_COMPANY"}]</label>
                <input name='pi_ratepay_rate0_company' maxlength='255' size='37' type='text' value='' class='form-control'/>
            </p>
            [{/if}]
            [{if isset($pi_ratepay_rate0_ust_check)}]
            <p style="margin-bottom: 15px;">
                <label>[{oxmultilang ident="PI_RATEPAY_RATE0_VIEW_PAYMENT_UST"}]</label>
                <input name='pi_ratepay_rate0_ust' maxlength='255' size='37' type='text' value='' class='form-control'/>
            </p>
            [{/if}]
            [{if $pi_ratepay_rate0_activateelv == 1}]
            <p style="margin-bottom: 15px;">
                <label for="piRpRadioWire">[{oxmultilang ident="PI_RATEPAY_VIEW_RADIO_PAYMENT_WIRE"}]</label>
                <input id="piRpRadioWire" type="radio" name="pi_rp_rate_pay_method" value="pi_ratepay_rate0_radio_wire" checked >
            </p>
            <p style="margin-bottom: 15px;">
                <label for="piRpRadioElv">[{oxmultilang ident="PI_RATEPAY_VIEW_RADIO_LABEL_ELV"}]</label>
                <input id="piRpRadioElv" type="radio" name="pi_rp_rate_pay_method" value="pi_ratepay_rate0_radio_elv">
            </p>
            [{/if}]
        </div>

        [{if $pi_ratepay_rate0_activateelv == 1}]
        <div id="pi_ratepay_rate0_bank_box" class="form">
            <p>
                <label>[{oxmultilang ident="PI_RATEPAY_ELV_VIEW_BANK_OWNER"}]:</label>
                <input name='pi_ratepay_rate0_bank_owner' maxlength='255' size='37' type='text' value='[{$piDbBankowner}]' class='form-control'/>
            </p>
            <p>
                <label>[{oxmultilang ident="PI_RATEPAY_ELV_VIEW_BANK_ACCOUNT_NUMBER"}]:</label>
                <input name='pi_ratepay_rate0_bank_account_number' maxlength='255' size='37' type='text' value='[{$piDbBankaccountnumber}]' class='form-control'/>
            </p>
        </div>
        [{/if}]
        [{ if isset($error)}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RECHNUNG_AGBERROR" }]</div>
        [{/if}]

        <br/>
        <link type="text/css" rel="stylesheet" href="modules/pi/ratepay/Installment/css/style.css"/>
        <script type="text/javascript" src="[{$oViewConf->getModuleUrl('ratepay')}]Installment/js/path.js"></script>
        <script type="text/javascript" src="[{$oViewConf->getModuleUrl('ratepay')}]Installment/js/layout.js"></script>
        <script type="text/javascript" src="[{$oViewConf->getModuleUrl('ratepay')}]Installment/js/ajax.js"></script>
        <script type="text/javascript" src="[{$oViewConf->getModuleUrl('ratepay')}]Installment/js/mouseaction.js"></script>
        [{if $pierror == "-461"}]
        <div class="alert alert-danger">
            [{oxmultilang ident="PI_RATEPAY_RATE0_ERROR_CALCULATE_TO_PROCEED"}]
        </div>
        [{/if}]
        <div id="pi_ratepay_rate0_pirpmain-cont"></div>
        <script type="text/javascript">
            if(document.getElementById('pi_ratepay_rate0_pirpmain-cont')){
                piLoadrateCalculator('pi_ratepay_rate0');
            }

        </script>
    </dd>
</dl>

[{oxscript add="piTogglePolicy('$sPaymentID');"}]
[{oxscript add="piCalculator();"}]
[{oxscript add="autoLoadPiCalculator('pi_ratepay_rate0');"}]
[{oxscript add="$('#pi_ratepay_rate0_bank_box').hide();"}]
[{oxscript add="piShow('#piRpRadioElv', '#pi_ratepay_rate0_bank_box');"}]
[{oxscript add="piHide('#piRpRadioWire', '#pi_ratepay_rate0_bank_box');"}]

[{else}]
[{$smarty.block.parent}]
[{/if}]
