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
                //this.saveCustomMessage();
                stepNavigator.next();
            }
        },
        saveCustomMessage: function () {
            let quoteId = quote.getQuoteId();

            let url = urlFormatter.build('order_message/quote/save');

            let customMessage = $('[name="custom_message"]').val();

            if (customMessage) {

                var payload = {
                    'cartId': quoteId,
                    'customMessage': customMessage,
                    'is_customer': isCustomer
                };

                if (!payload.customMessage) {
                    return true;
                }

                var result = true;

                $.ajax({
                    url: url,
                    data: payload,
                    dataType: 'text',
                    type: 'POST',
                }).done(
                    function (response) {
                        result = true;
                    }
                ).fail(
                    function (response) {
                        result = false;
                        errorProcessor.process(response);
                    }
                );
            }
        }
    });
});
