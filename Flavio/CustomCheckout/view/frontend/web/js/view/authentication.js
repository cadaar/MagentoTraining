define([
    'Magento_Checkout/js/view/authentication',
    'Magento_Customer/js/model/customer',
    'mage/storage',
    'mage/url',
    'ko'
], function(
    Component,
    customer,
    storage,
    url,
    ko
) {
    'use strict';

    return Component.extend({

        defaults: {
            template: 'Flavio_CustomCheckout/assistance-message',
            assistanceMessage: ko.observable(''),
        },

        initialize: function () {
            this._super();

            this.setAssistanceMessage();
            console.log(this.name + ' is loaded.');
        },
        isLoggedUser: function () {
            return customer.isLoggedIn();
        },
        getUrl: function () {
            return url.build('CustomCheckout/Store');
        },
        setAssistanceMessage: function () {
            storage
                .get(
                    this.getUrl(),
                )
                .done(response => {
                    this.fillAssistanceMessage(customer.customerData.firstname, response.value);
                })
                .fail(err => {
                    console.log('Error: ', err);
                    return '000 000 0000';
                });
        },
        fillAssistanceMessage: function (firstName, phoneNumber) {
            let message = 'Welcome <strong>{FIRST_NAME}</strong>!<br>Need help? call us at <b>{STORE_NUMBER}</b>'
                .replace('{FIRST_NAME}', firstName)
                .replace('{STORE_NUMBER}', phoneNumber);
            this.assistanceMessage(message);
        }
    });
});
