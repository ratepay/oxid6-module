<!--
*
* Copyright (c) Ratepay GmbH
*
*For the full copyright and license information, please view the LICENSE
*file that was distributed with this source code.
*-->
[{if $sPaymentID == "pi_ratepay_rechnung"}]
[{assign var="dynvalue" value=$oView->getDynValue()}]
<dl>
    <dt>
        <input id="payment_[{$sPaymentID}]" type="radio" name="paymentid" value="[{$sPaymentID}]" [{if $oView->getCheckedPaymentId() == $paymentmethod->oxpayments__oxid->value}]checked[{/if}] style="position:relative;">
        <label for="payment_[{$sPaymentID}]"><b>
                [{$paymentmethod->oxpayments__oxdesc->value}]
        </b></label>
    </dt>
    <dd class="[{if $oView->getCheckedPaymentId() == $paymentmethod->oxpayments__oxid->value}]activePayment[{/if}]" [{if $oView->getCheckedPaymentId() != $paymentmethod->oxpayments__oxid->value}]style="display:none"[{/if}]>
        [{if $pi_ratepay_rechnung_sandbox_notification == 1 }]
        <div id="sandbox_notification[{$sPaymentID}]" style="background: yellow; color: black; border: 3px dashed red; font-weight: bold; text-align: center; font-size:14px; padding-top: 10px; ">
            <p>
                [{oxmultilang ident="PI_RATEPAY_RECHNUNG_VIEW_SANDBOX_NOTIFICATION"}]
            </p>
        </div>
        [{/if}]
        <div>
            [{ oxmultilang ident="PI_RATEPAY_POLICY" }]
        </div>

        <div class="form" style="margin-top: 15px">
            [{if isset($pi_ratepay_rechnung_fon_check)}]
            <p style="margin-bottom: 15px;">
                <label>[{oxmultilang ident="PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_FON"}]</label>
                <input name='pi_ratepay_rechnung_fon' type='text' value='' size='37' class='form-control'/>
            </p>
            [{/if}]
            [{if isset($pi_ratepay_rechnung_birthdate_check)}]
            <p style="margin-bottom: 15px;">
                <label>[{oxmultilang ident="PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_BIRTHDATE"}]</label>
                <input name='pi_ratepay_rechnung_birthdate_day' maxlength='2' type='text' value='' data-fieldsize='small' class='form-control'/>
                <input name='pi_ratepay_rechnung_birthdate_month' maxlength='2' type='text' value='' data-fieldsize='small' class='form-control'/>
                <input name='pi_ratepay_rechnung_birthdate_year' maxlength='4' type='text' value='' data-fieldsize='small' class='form-control'/>
                <span class='note'>[{oxmultilang ident="PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_BIRTHDATE_FORMAT"}]</span>
            </p>
            [{/if}]
            [{if isset($pi_ratepay_rechnung_company_check)}]
            <p style="margin-bottom: 15px;">
                <label>[{oxmultilang ident="PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_COMPANY"}]</label>
                <input name='pi_ratepay_rechnung_company' maxlength='255' size='37' type='text' value='' class='form-control'/>
            </p>
            [{/if}]
            [{if isset($pi_ratepay_rechnung_ust_check)}]
            <p style="margin-bottom: 15px;">
                <label>[{oxmultilang ident="PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_UST"}]</label>
                <input name='pi_ratepay_rechnung_ust' maxlength='255' size='37' type='text' value='' class='form-control'/>
            </p>
            [{/if}]
        </div>
    </dd>
</dl>

[{oxscript add="piTogglePolicy('$sPaymentID');"}]

[{else}]
[{$smarty.block.parent}]
[{/if}]
