<!--
*
* Copyright (c) Ratepay GmbH
*
*For the full copyright and license information, please view the LICENSE
*file that was distributed with this source code.
*-->
[{oxstyle include="css/checkout.css"}]
[{capture append="oxidBlock_content"}]
[{* ordering steps *}]
[{include file="page/checkout/inc/steps.tpl" active=3 }]
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
        [{oxmultilang ident="PI_RATEPAY_RATE_ERROR_CALCULATE_TO_PROCEED"}]
    </div>
[{/if}]
<div id="pi_ratepay_rate_pirpmain-cont">

</div>
<script type="text/javascript">
    if(document.getElementById('pi_ratepay_rate_pirpmain-cont')){
    piLoadrateCalculator('pi_ratepay_rate');
}

</script>
<form action="[{ $oViewConf->getSslSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    [{ $oViewConf->getNavFormParams() }]
    <input type="hidden" name="cl" value="RatepayRateCalc">
    <input type="hidden" name="fnc" value="check">
    <div class="lineBox clear">
        <a href="[{ $oViewConf->getSslSelfLink() }]cl=Payment" class="submitButton largeButton" id="paymentBackStepBottom">[{ oxmultilang ident="PREVIOUS_STEP" }]</a>
        <button type="submit" name="userform" class="submitButton nextStep largeButton" id="paymentNextStepBottom">[{ oxmultilang ident="CONTINUE_TO_NEXT_STEP" }]</button>
    </div>

</form>
[{insert name="oxid_tracker" title=$template_title }]
[{/capture}]
[{include file="layout/page.tpl"}]
