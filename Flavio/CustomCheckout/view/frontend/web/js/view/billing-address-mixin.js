define([], function() {
    'use strict';

    return function(subject) {
        return subject.extend({
            defaults: {
                detailsTemplate: 'Flavio_CustomCheckout/billing-address/details'
            }
        });
    };
});
