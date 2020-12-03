<?php

/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @category  PayIntelligent
 * @package   PayIntelligent_RatePAY
 * @copyright (C) 2011 PayIntelligent GmbH  <http://www.payintelligent.de/>
 * @license http://www.gnu.org/licenses/  GNU General Public License 3
 */

/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$librarySubModel = 'pi/ratepay/library/src/Model/Request/SubModel/';
$libraryModel    = 'pi/ratepay/library/src/Model/';
$librarySubModelContent = 'RatePAY\Model\Request\SubModel\Content';

$aModule = array(
    'id'           => 'ratepay',
    'title'        => 'Ratepay',
    'description'  => array(
        'de' => 'Bezahlung mit Ratepay',
        'en' => 'Payment with Ratepay'
    ),
    'thumbnail'    => 'ratepay_logo.png',
    'lang'         => 'en',
    'version'      => '5.1.0',
    'author'       => 'Ratepay GmbH',
    'email'        => 'integration@ratepay.com',
    'url'          => 'http://www.ratepay.com/',
    'extend'      => array(
        // Extend controllers
        \OxidEsales\Eshop\Application\Controller\Admin\ModuleConfiguration::class => \pi\ratepay\Extend\Application\Controller\Admin\ModuleConfig::class,
        \OxidEsales\Eshop\Application\Controller\OrderController::class => \pi\ratepay\Extend\Application\Controller\Order::class,
        \OxidEsales\Eshop\Application\Controller\PaymentController::class => \pi\ratepay\Extend\Application\Controller\Payment::class,

        // Extend model
        \OxidEsales\Eshop\Application\Model\Order::class => \pi\ratepay\Extend\Application\Model\Oxorder::class,
        \OxidEsales\Eshop\Application\Model\PaymentGateway::class => \pi\ratepay\Extend\Application\Model\PaymentGateway::class,

        // Extend Core
        \OxidEsales\Eshop\Core\ShopControl::class => \pi\ratepay\Extend\Core\ShopControl::class
    ),
    'controllers' => array (
        'RatepayAdminListBase' => \pi\ratepay\Application\Controller\Admin\AdminListBase::class,
        'RatepayAdminViewBase' => \pi\ratepay\Application\Controller\Admin\AdminViewBase::class,
        'RatepayDetails' => \pi\ratepay\Application\Controller\Admin\Details::class,
        'RatepayLog' => \pi\ratepay\Application\Controller\Admin\Log::class,
        'RatepayLogList' => \pi\ratepay\Application\Controller\Admin\LogList::class,
        'RatepayLogMain' => \pi\ratepay\Application\Controller\Admin\LogMain::class,
        'RatepayProfile' => \pi\ratepay\Application\Controller\Admin\Profile::class,
        'RatepayProfileList' => \pi\ratepay\Application\Controller\Admin\ProfileList::class,
        'RatepayProfileMain' => \pi\ratepay\Application\Controller\Admin\ProfileMain::class,
        'RatepayRate0Calc' => \pi\ratepay\Application\Controller\Rate0Calc::class,
        'RatepayRateCalc' => \pi\ratepay\Application\Controller\RateCalc::class,
        'RatepayModuleConfig' => \pi\ratepay\Extend\Application\Controller\Admin\ModuleConfig::class,
        'RatepayOrder' => \pi\ratepay\Extend\Application\Controller\Order::class,
        'RatepayPayment' => \pi\ratepay\Extend\Application\Controller\Payment::class,
    ),
    'templates' => array(
        // views->admin
        'pi_ratepay_log.tpl'                            => 'pi/ratepay/Application/views/admin/tpl/pi_ratepay_log.tpl',
        'pi_ratepay_log_list.tpl'                       => 'pi/ratepay/Application/views/admin/tpl/pi_ratepay_log_list.tpl',
        'pi_ratepay_log_main.tpl'                       => 'pi/ratepay/Application/views/admin/tpl/pi_ratepay_log_main.tpl',
        'pi_ratepay_details.tpl'                        => 'pi/ratepay/Application/views/admin/tpl/pi_ratepay_details.tpl',
        'pi_ratepay_no_details.tpl'                     => 'pi/ratepay/Application/views/admin/tpl/pi_ratepay_no_details.tpl',
        'pi_ratepay_profile.tpl'                        => 'pi/ratepay/Application/views/admin/tpl/pi_ratepay_profile.tpl',
        'pi_ratepay_profile_list.tpl'                   => 'pi/ratepay/Application/views/admin/tpl/pi_ratepay_profile_list.tpl',
        'pi_ratepay_profile_main.tpl'                   => 'pi/ratepay/Application/views/admin/tpl/pi_ratepay_profile_main.tpl',
    ),
    'events' => array(
        'onActivate'                => '\pi\ratepay\Core\Events::onActivate',
        'onDeactivate'              => '\pi\ratepay\Core\Events::onDeactivate',
    ),
    'blocks' => array(
        array(
            'template' => 'page/checkout/payment.tpl',
            'block'    => 'checkout_payment_errors',
            'file'     => 'payment_pi_ratepay_error_dfp.tpl'
        ),
        array(
            'template' => 'page/checkout/payment.tpl',
            'block'    => 'select_payment',
            'file'     => 'payment_pi_ratepay_rechnung.tpl'
        ),
        array(
            'template' => 'page/checkout/payment.tpl',
            'block'    => 'select_payment',
            'file'     => 'payment_pi_ratepay_rate.tpl'
        ),
        array(
            'template' => 'page/checkout/payment.tpl',
            'block'    => 'select_payment',
            'file'     => 'payment_pi_ratepay_rate0.tpl'
        ),
        array(
            'template' => 'page/checkout/payment.tpl',
            'block'    => 'select_payment',
            'file'     => 'payment_pi_ratepay_elv.tpl'
        ),
        array(
            'template' => 'page/checkout/order.tpl',
            'block'    => 'checkout_order_main',
            'file'     => 'order_pi_ratepay_waitingwheel.tpl'
        ),
        array(
            'template' => 'page/checkout/order.tpl',
            'block'    => 'shippingAndPayment',
            'file'     => 'order_pi_ratepay_rate.tpl'
        ),
        array(
            'template' => 'module_config.tpl',
            'block'    => 'admin_module_config_form',
            'file'     => 'admin_pi_ratepay_module_config_form.tpl',
        ),
        array(
            'template' => 'module_config.tpl',
            'block'    => 'admin_module_config_var_type_select',
            'file'     => 'admin_pi_ratepay_module_config_var_type_select.tpl',
        ),
    ),
    'settings' => array(
        // ratepay general
        array('group' => 'PI_RATEPAY_GENERAL', 'name' => 'blRPLogging', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_GENERAL', 'name' => 'blRPAutoPaymentConfirm', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_GENERAL', 'name' => 'sRPDeviceFingerprintSnippetId', 'type' => 'str', 'value' => ''),
        // ratepay germany invoice
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'blRPInvoiceActive', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'blRPInvoiceSandbox', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'sRPInvoiceProfileId', 'type' => 'str', 'value' => ''),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'sRPInvoiceSecret', 'type' => 'str', 'value' => ''),
        // ratepay germany installment
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'blRPInstallmentActive', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'blRPInstallmentSandbox', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'sRPInstallmentProfileId', 'type' => 'str', 'value' => ''),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'sRPInstallmentSecret', 'type' => 'str', 'value' => ''),
        // ratepay germany installment 0%
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'blRPInstallment0Active', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'blRPInstallment0Sandbox', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'sRPInstallment0ProfileId', 'type' => 'str', 'value' => ''),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'sRPInstallment0Secret', 'type' => 'str', 'value' => ''),
        // ratepay germany elv
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'blRPElvActive', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'blRPElvSandbox', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'sRPElvProfileId', 'type' => 'str', 'value' => ''),
        array('group' => 'PI_RATEPAY_GERMANY', 'name' => 'sRPElvSecret', 'type' => 'str', 'value' => ''),
        // ratepay austria invoice
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'blRPAustriaInvoice', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'blRPAustriaInvoiceSandbox', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'sRPAustriaInvoiceProfileId', 'type' => 'str', 'value' => ''),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'sRPAustriaInvoiceSecret', 'type' => 'str', 'value' => ''),
        // ratepay austria installment
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'blRPAustriaInstallment', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'blRPAustriaInstallmentSandbox', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'sRPAustriaInstallmentProfileId', 'type' => 'str', 'value' => ''),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'sRPAustriaInstallmentSecret', 'type' => 'str', 'value' => ''),
        // ratepay austria installment 0%
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'blRPAustriaInstallment0', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'blRPAustriaInstallment0Sandbox', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'sRPAustriaInstallment0ProfileId', 'type' => 'str', 'value' => ''),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'sRPAustriaInstallment0Secret', 'type' => 'str', 'value' => ''),
        // ratepay austria elv
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'blRPAustriaElv', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'blRPAustriaElvSandbox', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'sRPAustriaElvProfileId', 'type' => 'str', 'value' => ''),
        array('group' => 'PI_RATEPAY_AUSTRIA', 'name' => 'sRPAustriaElvSecret', 'type' => 'str', 'value' => ''),
        // ratepay switzerland invoice
        array('group' => 'PI_RATEPAY_SWITZERLAND', 'name' => 'blRPSwitzerlandInvoice', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_SWITZERLAND', 'name' => 'blRPSwitzerlandInvoiceSandbox', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_SWITZERLAND', 'name' => 'sRPSwitzerlandInvoiceProfileId', 'type' => 'str', 'value' => ''),
        array('group' => 'PI_RATEPAY_SWITZERLAND', 'name' => 'sRPSwitzerlandInvoiceSecret', 'type' => 'str', 'value' => ''),
        // ratepay netherland invoice
        array('group' => 'PI_RATEPAY_NETHERLAND', 'name' => 'blRPNetherlandInvoice', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_NETHERLAND', 'name' => 'blRPNetherlandInvoiceSandbox', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_NETHERLAND', 'name' => 'sRPNetherlandInvoiceProfileId', 'type' => 'str', 'value' => ''),
        array('group' => 'PI_RATEPAY_NETHERLAND', 'name' => 'sRPNetherlandInvoiceSecret', 'type' => 'str', 'value' => ''),
        // ratepay netherland elv
        array('group' => 'PI_RATEPAY_NETHERLAND', 'name' => 'blRPNetherlandElv', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_NETHERLAND', 'name' => 'blRPNetherlandElvSandbox', 'type' => 'bool', 'value' => false),
        array('group' => 'PI_RATEPAY_NETHERLAND', 'name' => 'sRPNetherlandElvProfileId', 'type' => 'str', 'value' => ''),
        array('group' => 'PI_RATEPAY_NETHERLAND', 'name' => 'sRPNetherlandElvSecret', 'type' => 'str', 'value' => ''),
    ),
);
