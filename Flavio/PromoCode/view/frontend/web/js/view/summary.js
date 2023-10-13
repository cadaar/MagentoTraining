/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Checkout/js/view/summary',
    //'Magento_Checkout/js/model/totals',
    'Magento_Customer/js/customer-data',
    'ko',
    'underscore'
], function (
    Component,
    //totals,
    customerData,
    ko,
    _,
) {
    'use strict';

    return Component.extend({
        defaults: {
            couponThreshold: 100,
            couponValue: '10%',
            subtotal: 0.00,
            tracks: {
                subtotal: true
            },
            //promoMessage: ko.observable(''),
        },
        initialize: function () {
            let self = this;
            self._super();
            let cart = customerData.get('cart');

            customerData.getInitCustomerData().done(function () {
                if (!_.isEmpty(cart()) && !_.isUndefined(cart().subtotalAmount)) {
                    self.subtotal = parseFloat(cart().subtotalAmount);
                }
            });

            cart.subscribe(function (cart) {
                if (!_.isEmpty(cart) && !_.isUndefined(cart.subtotalAmount)) {
                    self.subtotal = parseFloat(cart.subtotalAmount);
                }
            });

            self.promoMessage = ko.computed(function () {
                if (_.isUndefined(self.subtotal) || self.subtotal === 0) {
                    self.subtotal = 0;
                }

                if (self.subtotal >= self.couponThreshold) {
                    return self.messageFreeCoupon
                        .replace('{{GET100}}', '<strong>GET100</strong>')
                        .replace('{{10%}}', '<strong>10%</strong>');
                } else {
                    let subtotalRemaining = self.couponThreshold - self.subtotal;
                    let formattedSubtotalRemaining =
                        '<strong>' + self.formatCurrency(subtotalRemaining) + '</strong>';

                    return self.messageDefault.replace('{{XX}}', formattedSubtotalRemaining);
                }

            });

            console.log(this.name + ' is loaded.');
        },
        formatCurrency: function (value) {
            return value.toFixed(2);
        }
    });
});
