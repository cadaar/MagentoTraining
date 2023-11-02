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
        defaults: {
            template: 'Flavio_Bookmarks/bookmark-grid',
            bookmarks: ko.observableArray([
                {id: 1, title:'Page 1', url: 'https://www.google.com/'},
                {id: 2, title:'Page 2', url: 'url 2'},
                {id: 3, title:'Page 3', url: 'url 3'},
                {id: 4, title:'Page 4', url: 'url 4'},
            ])
        },
        initialize: function() {
            this._super();
            console.log(this.name + ' is initialized.');
        },
        deleteItem: function (data) {
            console.log('id: ' + data.id);
            this.bookmarks.remove(function(item) {
                return item.id === data.id;
            });
        },
        isBookmarkListEmpty: function () {
            return this.bookmarks().length === 0;
        }

    });
});
