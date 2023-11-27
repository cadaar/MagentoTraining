define([
    'uiComponent',
    'mage/storage',
    'mage/url',
    'Magento_Customer/js/customer-data',
    'ko',
    'underscore'
], function(
    Component,
    storage,
    url,
    customerData,
    ko,
    _
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Flavio_Bookmarks/bookmark-global-handler',
            currentPageUrl: '',
            currentBookmarkId: 0,
            isBookmarked: ko.observable(false),
        },
        initialize: function() {
            this._super();

            this.currentPageUrl = window.location.href;

            this.switchBookmark();

            console.log(this.name + ' is initialized.');
        },
        updateBookmark: function () {
            if (this.currentBookmarkId) {
                this.deleteBookmark();
            } else {
                this.addBookmark();
            }
        },
        switchBookmark: function () {
            let bookmarksSection = customerData.get('bookmarks-section');

            let isPageBookmarked = ko.computed(() => {
                return bookmarksSection()['items'].some(
                    elem => elem.url === this.currentPageUrl);
            });

            this.isBookmarked(isPageBookmarked);
        },
        addBookmark: function () {
            let bookmark = {
                page_title: document.title,
                url: this.currentPageUrl,
            };
            storage
                .post(
                    `${this.getApiUrl()}post`,
                    JSON.stringify({'bookmark': bookmark}), true, 'application/json'
                )
                .done(response => {
                    if (response.id) {
                        this.currentBookmarkId = response.id;
                        this.switchBookmark();
                    }
                })
                .fail(err => {
                    console.log('Error: ', err);
                });
        },
        deleteBookmark: function () {
            storage
                .delete(
                    `${this.getApiUrl()}delete/${encodeURIComponent(this.currentBookmarkId)}`
                )
                .done(response => {
                    if (response) {
                        this.currentBookmarkId = 0;
                        this.switchBookmark();
                    }
                })
                .fail(err => {
                    console.log('Error: ', err);
                });
        },
        getApiUrl: function () {
            return `${BASE_URL}rest/V1/bookmarks_bookmark/`;
        },

    });
});
