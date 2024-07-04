# Ratepay GmbH - OXID6 Payment Module
============================================

|Module | Ratepay Payment Module for OXID6
|------|----------
|Author | `Fatchip GmbH`
|Prefix | `pi`
|Shop Version | `CE/PE` `CE/PE/EE` `6.0.x-6.5.x`
|Version | `6.2.2`
|Link | http://www.ratepay.com
|Mail | integration@ratepay.com
|Full Documentation | [click here](https://docs.ratepay.com/docs/developer/shop_modules/oxid/ratepay_payment_plugin_for_oxid/)|
|Legal Disclaimer   | [click here](https://docs.ratepay.com/docs/developer/shop_modules/overview/)| 

## Changelog

### Version 6.2.2 - Released 2024-07-04
* Fix : DFP template inheritance

### Version 6.2.1 - Released 2024-07-04
* Fix : Admin requests voucher calculation

### Version 6.2.0 - Released 2024-01-25
* Fix : Voucher requests in Net price mode
* Fix : Currency swapping in order post-processing
* Fix : Disabling/Enabling checkout button between regular and RP methods
* Update : Restrict DFP loading to minimal necessity
* Update : Various styling

### Version 6.1.2 - Released 2023-01-17
* Update : Change Docblock headers
* Update : New Ratepay GmbH address

### Version 6.1.1 - Released 2022-08-23
* Fixed : Bug when using descriptions for identical order items
* Fixed : EN translations
* Update : Data saved in request logs
* Update : Obsolete param from profile removed

### Version 6.1.0 - Released 2022-01-11
* Fix: Bug while displaying logs entries, due to CamelCase/Lower case classnames incompatibility
* Update: Design enhancement in logs details display (syntax highlight, bold title)
* Update: Module tag version was made dynamic in xml request header

### Version 6.0.1 - Released 2021-04-08
* Added pre-calculation to estimate max valid runtime for 0% interest rate cases
* Extend width of installment calculator detail on order review page
* Fixed issue with plugin order
* Fixed SQL to target correct Ratepay details entries for older orders

### Version 6.0.0 - Released 2021-02-05
* Initial release of standalone OXID 6 plugin
