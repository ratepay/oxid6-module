[{$smarty.block.parent}]
[{if $pi_payment->getId() == "pi_ratepay_rate0"}]
    <link type="text/css" rel="stylesheet" href="modules/pi/ratepay/Installment/css/style.css"/>
    <script type="text/javascript" src="[{$oViewConf->getModuleUrl('ratepay')}]Installment/js/path.js"></script>
    <script type="text/javascript" src="[{$oViewConf->getModuleUrl('ratepay')}]Installment/js/layout.js"></script>
    <script type="text/javascript" src="[{$oViewConf->getModuleUrl('ratepay')}]Installment/js/ajax.js"></script>
    <script type="text/javascript" src="[{$oViewConf->getModuleUrl('ratepay')}]Installment/js/mouseaction.js"></script>
    <div id="pi_ratepay_rate0_pirpmain-cont">

    </div>
    <script type="text/javascript">
    if(document.getElementById('pi_ratepay_rate0_pirpmain-cont')) {
        piLoadrateResult('pi_ratepay_rate0');
    }
    </script>
[{/if}]