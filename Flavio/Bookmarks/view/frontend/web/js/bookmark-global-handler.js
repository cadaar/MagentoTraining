define([
    'uiComponent',
    'ko',
    'Magento_Customer/js/customer-data',
    'underscore',
    'jquery'
], function(
    Component,
    ko,
    customerData,
    _,
    $
) {
    'use strict';

    return Component.extend({

        initialize: function() {
            this._super();

            console.log(this.name + ' is initialized.');

        },
        updateBookmark: function () {
            console.log('UpdateBookmark was clicked.');
            let star = $('#bookmark-star');
            star.addClass('selected');
            //console.log('star: ', star);
            console.log(star[0].classList);
        }

    });
});
