define([
    'uiComponent',
    'ko',
    'mage/storage',
    'mage/url',
    'underscore',
], function(
    Component,
    ko,
    storage,
    url,
    _,
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Flavio_Bookmarks/bookmark-grid',
            bookmarks: ko.observableArray()
        },
        initialize: function(config) {
            this._super();
            this.bookmarks(config.bookmarkListVm);
            console.log(this.name + ' is initialized.');
        },
        deleteItem: function (data) {
            this.removeBookmark(data.id);
        },
        getUrl: function (id) {
            return BASE_URL + 'rest/V1/bookmarks_bookmark/' + id;
        },
        removeBookmark: function (id) {
            storage
                .delete(
                    this.getUrl(id),
                )
                .done(function() {
                    this.bookmarks.remove(function(item) {
                        return item.id === id;
                    });
                })
                .fail(err => {
                    console.log('Error: ', err);
                });
        },
        isBookmarkListEmpty: function () {
            return this.bookmarks().length === 0;
        }

    });
});
