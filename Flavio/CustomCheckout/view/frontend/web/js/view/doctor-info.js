define([
    'uiComponent',
    'ko',
    'Magento_Checkout/js/model/step-navigator',
    'mage/translate',
    'underscore',
    'Magento_Checkout/js/model/quote',
    'Magento_Customer/js/model/customer',
    'jquery',
    'Magento_Checkout/js/model/customer-email-validator'
], function(
    Component,
    ko,
    stepNavigator,
    $t,
    _,
    quote,
    customer,
    $,
    customerEmailValidator
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Flavio_CustomCheckout/doctor-info',
            isVisible: ko.observable(false),
            doctorName: ko.observable('Doctor Who'),
            doctorPhone: ko.observable('999 999 9999'),
        },
        quoteIsVirtual: quote.isVirtual(),
        initialize: function() {
            this._super();

            stepNavigator.registerStep(
                'doctor-info',
                null,
                $t("Doctor's Info"),
                this.isVisible,
                _.bind(this.navigate, this),
                this.sortOrder
            );

            console.log(this.name + ' is initialized.')
            return this;
        },
        navigate: function() {
            this.isVisible(true);
        },
        navigateToNextStep: function () {
            stepNavigator.next();
            // if (customerEmailValidator.validate()) {
            //     stepNavigator.next();
            // }
        }
    });
});
