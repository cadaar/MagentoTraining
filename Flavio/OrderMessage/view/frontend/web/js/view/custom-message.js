define([
    'uiComponent',
    'ko',
    'Magento_Checkout/js/model/step-navigator',
    'mage/translate',
    'underscore',
    'Magento_Checkout/js/model/quote',
    'Magento_Customer/js/model/customer',
    'jquery'
], function(
    Component,
    ko,
    stepNavigator,
    $t,
    _,
    quote,
    customer,
    $
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Flavio_OrderMessage/custom-message',
            isVisible: ko.observable(true),
            customMessage: ko.observable(''),
        },
        quoteIsVirtual: quote.isVirtual(),
        initialize: function() {
            this._super();

            stepNavigator.registerStep(
                'custom-message',
                null,
                $t("Custom Message"),
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
            let formSelector = 'form[data-role=custom-message-data-role]'
            $(formSelector).validation();
            let messageValidation = Boolean($(formSelector + ' input[name=customMessage]').valid());
            if (messageValidation) {
                stepNavigator.next();
            }
        }
    });
});
