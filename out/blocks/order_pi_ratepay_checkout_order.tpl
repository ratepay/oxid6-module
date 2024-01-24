<!--
*
* Copyright (c) Ratepay GmbH
*
*For the full copyright and license information, please view the LICENSE
*file that was distributed with this source code.
*-->
[{if $pi_payment->getId()  == "pi_ratepay_rate" || $pi_payment->getId()  == "pi_ratepay_rate0" || $pi_payment->getId()  == "pi_ratepay_rechnung" || $pi_payment->getId()  == "pi_ratepay_elv"}]
    [{if isset($pi_ratepay_dfp_token)}]
    <noscript><link rel="stylesheet" type="text/css" href="//d.ratepay.com/di.css?t=[{$pi_ratepay_dfp_token}]&v=[{$pi_ratepay_dfp_snippet_id}]&l=Checkout"></noscript>
    <object type="application/x-shockwave-flash" data="//d.ratepay.com/[{$pi_ratepay_dfp_snippet_id}]/c.swf" style="float: right; visibility: hidden; height: 0px; width: 0px;">
        <param name="movie" value="//d.ratepay.com/[{$pi_ratepay_dfp_snippet_id}]/c.swf" />
        <param name="flashvars" value="t=[{$pi_ratepay_dfp_token}]&v=[{$pi_ratepay_dfp_snippet_id}]&l=Checkout"/>
        <param name="AllowScriptAccess" value="always"/>
    </object>
    [{/if}]
[{/if}]
[{if $pi_payment->getId()  == "pi_ratepay_rate" || $pi_payment->getId()  == "pi_ratepay_rate0" || $pi_payment->getId()  == "pi_ratepay_rechnung"}]
<form action="[{ $oViewConf->getSslSelfLink() }]" method="post" id="orderConfirmAgbBottom">
    [{ $oViewConf->getHiddenSid() }]
    [{ $oViewConf->getNavFormParams() }]
    <input type="hidden" name="cl" value="RatepayOrder">
    <input type="hidden" name="fnc" value="[{$oView->getExecuteFnc()}]">
    <input type="hidden" name="challenge" value="[{$challenge}]">
    <input type="hidden" name="ord_agb" value="1">
    [{if $oView->piIsFourPointSixShop()}]
        <input type="hidden" name="sDeliveryAddressMD5" value="[{$oView->getDeliveryAddressMD5()}]">
    [{/if}]
    <div class="agb">
        [{if $oView->isActive('PsLogin') }]
        <input type="hidden" name="ord_agb" value="1">
        [{else}]
        [{if $oView->isConfirmAGBActive()}]
        [{oxifcontent ident="oxrighttocancellegend" object="oContent"}]
        <h3 class="section">
            <strong>[{ $oContent->oxcontents__oxtitle->value }]</strong>
        </h3>
        <input type="hidden" name="ord_agb" value="0">
        <input id="checkAgbBottom" class="checkbox" type="checkbox" name="ord_agb" value="1">
        [{ $oContent->oxcontents__oxcontent->value }]
        [{/oxifcontent}]
        <p class="errorMsg" name="agbError">[{ oxmultilang ident="PAGE_CHECKOUT_ORDER_READANDCONFIRMTERMS" }]</p>
        [{else}]
        [{oxifcontent ident="oxrighttocancellegend2" object="oContent"}]
        <h3 class="section">
            <strong>[{ $oContent->oxcontents__oxtitle->value }]</strong>
        </h3>
        <input type="hidden" name="ord_agb" value="1">
        [{ $oContent->oxcontents__oxcontent->value }]
        [{/oxifcontent}]
        [{/if}]

        [{/if}]
    </div>
    <div class="lineBox clear">
        <div id="waitingWheel" class="popup" style="visibility:hidden;background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #000000;display: block; height: 150px;left: 50%;margin-left: -135px;margin-top: -75px; padding: 10px;position: fixed;top: 50%;width: 270px;z-index: 2000;">
            <p>Bitte warten, Ihre Anfrage wird gerade &uuml;berpr&uuml;ft. Schlie&szlig;en Sie diese Seite nicht und klicken Sie nicht "Reload" bis die &Uuml;berpr&uuml;fung abgeschlossen ist. Dies wird ca. 10 Sekunden dauern.</p>
            <center><img class="waitIMG" src="[{$oViewConf->getModuleUrl('ratepay')}]out/admin/img/ajax-loader.gif" alt="wait"/></center>
        </div>
        <a href="[{ $oViewConf->getSslSelfLink() }]cl=Payment" class="submitButton largeButton">[{ oxmultilang ident="PREVIOUS_STEP" }]</a>
        <button type="submit" class="submitButton nextStep largeButton"  onClick="showWaitingWheel()">[{ oxmultilang ident="SUBMIT_ORDER" }]</button>
    </div>
</form>
[{else}]
[{$smarty.block.parent}]
[{/if}]
