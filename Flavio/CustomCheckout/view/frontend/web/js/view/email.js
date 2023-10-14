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
            template: 'Flavio_CustomCheckout/email',
            isVisible: ko.observable(false),
            emailAddress: window.checkoutConfig.quoteData.customer_email
        },
        quoteIsVirtual: quote.isVirtual(),
        initialize: function() {
            this._super();

            stepNavigator.registerStep(
                'email',
                null,
                $t('Email'),
                this.isVisible,
                _.bind(this.navigate, this),
                this.sortOrder
            );

            console.log('window.checkoutConfig.quoteData.customer_email: ' + window.checkoutConfig.quoteData.customer_email);

            console.log(this.name + ' is loaded.')
            return this;
        },
        navigate: function() {
            this.isVisible(true);
        },
        navigateToNextStep: function () {
            const customerEmail = window.checkoutConfig.quoteData.customer_email;

            if (customer.isLoggedIn() && (customerEmail !== this.emailAddress)) {
                console.log('Need to update the customer email address.');
            }

            if (customerEmailValidator.validate()) {
                stepNavigator.next();
            }
        }
    });
});
