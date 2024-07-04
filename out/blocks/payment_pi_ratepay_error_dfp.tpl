<!--
*
* Copyright (c) Ratepay GmbH
*
*For the full copyright and license information, please view the LICENSE
*file that was distributed with this source code.
*-->
[{oxscript add="piAttachClickEvents();"}]
[{oxscript add="piCheckFingerprint();"}]

[{$smarty.block.parent}]

[{foreach from=$piRatepayErrors item=pierror}]

    [{if $pierror == "-300"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ELV_ERROR" }]<a href="[{$pi_ratepay_elv_url}]" target="_blank">[{ oxmultilang ident="PI_RATEPAY_RATE_VIEW_POLICY_PRIVACYPOLICY" }]</a>.</div>
    [{/if}]

    <!-- Rechnung -->
    [{if $pierror == "-400"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RECHNUNG_ERROR" }]<a href="[{$pi_ratepay_rechnung_url}]" target="_blank">[{ oxmultilang ident="PI_RATEPAY_RECHNUNG_VIEW_POLICY_PRIVACYPOLICY" }]</a>.</div>
    [{/if}]

    [{if $pierror == "-401"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RECHNUNG_ERROR_BIRTH" }]</div>
    [{/if}]

    [{if $pierror == "-404"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RECHNUNG_ERROR_PHONE" }]</div>
    [{/if}]

    [{if $pierror == "-405"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RECHNUNG_ERROR_ADDRESS" }]</div>
    [{/if}]

    [{if $pierror == "-406"}]
    <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RECHNUNG_ERROR_ZIP" }]</div>
    [{/if}]

    [{if $pierror == "-414"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RECHNUNG_ERROR_AGE" }]</div>
    [{/if}]

    <!-- Rate -->
    [{if $pierror == "-407"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RATE_ERROR" }]<a href="[{$pi_ratepay_rate_url}]" target="_blank">[{ oxmultilang ident="PI_RATEPAY_RATE_VIEW_POLICY_PRIVACYPOLICY" }]</a>.</div>
    [{/if}]

    [{if $pierror == "-408"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RATE_ERROR_BIRTH" }]</div>
    [{/if}]

    [{if $pierror == "-412"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RATE_ERROR_ADDRESS" }]</div>
    [{/if}]

    [{if $pierror == "-413"}]
    <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RATE_ERROR_ZIP" }]</div>
    [{/if}]

    [{if $pierror == "-415"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RATE_ERROR_AGE" }]</div>
    [{/if}]

    [{if $pierror == "-460"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_RATE_ERROR_PHONE" }]</div>
    [{/if}]

    <!-- ELV -->
    [{if $pierror == "-500"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ELV_ERROR_OWNER" }]</div>
    [{/if}]
    [{if $pierror == "-501"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ELV_ERROR_ACCOUNT_NUMBER" }]</div>
    [{/if}]
    [{if $pierror == "-502"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ELV_ERROR_CODE" }]</div>
    [{/if}]
    [{if $pierror == "-504"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ELV_ERROR" }]<a href="[{$pi_ratepay_elv_url}]" target="_blank">[{ oxmultilang ident="PI_RATEPAY_ELV_VIEW_POLICY_PRIVACYPOLICY" }]</a>.</div>
    [{/if}]

    [{if $pierror == "-505"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ELV_ERROR_BIRTH" }]</div>
    [{/if}]

    [{if $pierror == "-506"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ELV_ERROR_ADDRESS" }]</div>
    [{/if}]

    [{if $pierror == "-507"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ELV_ERROR_AGE" }]</div>
    [{/if}]

    [{if $pierror == "-508"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ELV_ERROR_PHONE" }]</div>
    [{/if}]

    [{if $pierror == "-509"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ELV_ERROR_BANKCODE_TO_SHORT" }]</div>
    [{/if}]

    [{if $pierror == "-511"}]
    <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ELV_ERROR_ZIP" }]</div>
    [{/if}]

    <!-- All -->
    [{if $pierror == "-416"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ERROR_COMPANY" }]</div>
    [{/if}]

    [{if $pierror == "-418"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ERROR_CONNECTION_TIMEOUT" }]</div>
    [{/if}]

    [{if $pierror == "-419"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ERROR_BIRTHDAY_YEAR_DIGITS" }]</div>
    [{/if}]

    [{if $pierror == "-835"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ERROR_COMPANY_BIRTHDAY_DIGITS" }]</div>
    [{/if}]

    [{if $pierror == "-461"}]
        <div class="alert alert-danger">[{ oxmultilang ident="PI_RATEPAY_ERROR_PRIVACY_AGREEMENT" }]</div>
    [{/if}]

    [{if $pierror == "-001"}]
        <div class="alert alert-danger">[{$customer_message}]</div>
    [{/if}]
[{/foreach}]

<script language="JavaScript" async>
    function piCheckFingerprint () {
        var paymentid = '';

        var elements = $('input[name=paymentid]');
        $.each(elements, function( index, element) {
            if (element.checked) {
                paymentid = element.value;
            }
        });

        if (
            paymentid == 'pi_ratepay_rate' ||
            paymentid == 'pi_ratepay_rate0' ||
            paymentid == 'pi_ratepay_elv' ||
            paymentid == 'pi_ratepay_rechnung') {

            [{if !isset($pi_ratepay_script_send)}]
            if (typeof blInserted == 'undefined') {
                var diSkriptVar = document.createElement('script');
                diSkriptVar.type = 'text/javascript';
                diSkriptVar.text =  "var blInserted = true;var di = {t:'{{ pi_ratepay_dfp_token }}',v:'{{ pi_ratepay_dfp_snippet_id }}',l:'Checkout'};";
                document.getElementsByTagName('head')[0].appendChild(diSkriptVar);

                var diSkript = document.createElement('script');
                diSkript.type = 'text/javascript';
                diSkript.src = '//d.ratepay.com/{{ pi_ratepay_dfp_snippet_id }}/di.js';
                document.getElementsByTagName('head')[0].appendChild(diSkript);
                $.ajax({
                    type: "POST",
                    url: '/index.php?cl=RatepayPayment&fnc=setDiScriptSendAjax',
                });
            }
            [{/if}]
        }
    }
</script>

<script type="text/javascript">
function piAttachClickEvents(){
    var elements = $('input[name=paymentid]');
    $.each(elements, function( index, element ) {
        element.addEventListener('click', piCalculator);
    });
    $.each(elements, function( index, element ) {
        element.addEventListener('click', piCheckFingerprint);
    });
}
function piTogglePolicy(policy) {
    $('#policyButton' + policy).click(function() {
        $('.policyButtonText' + policy).toggle();
        $('#policy' + policy).toggle();
    });
}

function piShow(input, elementToToggle) {
    $(input).click(function() {
        $(elementToToggle).show();
    });
}

function piHide(input, elementToToggle) {
    $(input).click(function() {
        $(elementToToggle).hide();
    });
}
function piCalculator() {
    if ($('#payment_pi_ratepay_rate').is(':checked') || $('#payment_pi_ratepay_rate0').is(':checked')) {
        var agreementCheckbox = $('#rp-sepa-aggreement');
        agreementCheckbox.prop('checked', false);
        $('#paymentNextStepBottom').prop('disabled', true);
    } else if ($('#payment_pi_ratepay_elv').is(':checked')) {
        agreementCheckbox = $('#pi_ratepay_elv_sepa_agreement_check');
        agreementCheckbox.prop('checked', false);
        $('#paymentNextStepBottom').prop('disabled', true);
    } else {
        $('#paymentNextStepBottom').prop('disabled', false);
    }
}
function autoLoadPiCalculator(methodName) {
    if ($('#payment_' + methodName).is(':checked')) {
        var idPattern = methodName+'_piRpInput-buttonMonth';
        var runtimeButtons = $("button[id^="+idPattern+"]");
        if (runtimeButtons.length === 0) {
            return;
        }

        var month = runtimeButtons[0].innerText;
        piRatepayRateCalculatorAction('runtime', methodName, month);
    }
}
function checkElvForm() {
    if ($('#payment_pi_ratepay_elv').is(':checked')) {
        var agreementCheckbox = $('#pi_ratepay_elv_sepa_agreement_check');
        var ibanField = $('#pi_ratepay_elv_bank_iban');

        if (ibanField.val() !== '' && agreementCheckbox.is(':checked')) {
            $('#paymentNextStepBottom').prop('disabled', false);

        } else {
            $('#paymentNextStepBottom').prop('disabled', true);
        }
    }
}
</script>
