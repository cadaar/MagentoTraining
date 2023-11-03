define([
    'uiComponent',
    'mage/storage',
    'mage/url',
    'ko',
    'underscore',
    'jquery'
], function(
    Component,
    storage,
    url,
    ko,
    _,
    $
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Flavio_Bookmarks/bookmark-global-handler',
            currentPageTitle: '',
            currentPageUrl: '',
            currentCustomerId: '',
            currentBookmarkId: 0,
        },
        initialize: function(config) {
            this._super();

            this.currentPageTitle = config.currentPageTitle;
            this.currentPageUrl = config.currentPageUrl;
            this.currentCustomerId = config.currentCustomerId;
            this.initializeStar();

            console.log(this.name + ' is initialized.');
        },
        updateBookmark: function () {
            if (this.currentBookmarkId) {
                this.deleteBookmark();
            } else {
                this.addBookmark();
            }
        },
        initializeStar: function () {
            storage
                .get(this.getUrlGetByUrl())
                .done(response => {
                    if (response) {
                        this.currentBookmarkId = response;
                        this.toggleStar();
                    }
                })
                .fail(err => {
                    console.log('Error: ', err);
                });
        },
        getUrlGetByUrl: function () {
            let url = BASE_URL + 'rest/V1/bookmarks_bookmark/url/' + encodeURIComponent(this.currentPageUrl);
            return url;
        },
        addBookmark: function () {
            let bookmark = {
                page_title: this.currentPageTitle,
                url: this.currentPageUrl,
                customer_id: this.currentCustomerId
            };
            let data = JSON.stringify(bookmark);
            storage
                .post(
                    this.getApiPostUrl(),
                    JSON.stringify({'bookmark': bookmark}), true, 'application/json'
                )
                .done(response => {
                    if (response.id) {
                        this.currentBookmarkId = response.id;
                        this.toggleStar();
                    }
                })
                .fail(err => {
                    console.log('Error: ', err);
                });
        },
        getApiPostUrl: function () {
            return BASE_URL + 'rest/V1/bookmarks_bookmark/';
        },
        deleteBookmark: function () {
            storage
                .delete(
                    this.getApiDeleteUrl()
                )
                .done(response => {
                    if (response) {
                        this.currentBookmarkId = 0;
                        this.toggleStar();
                    }
                })
                .fail(err => {
                    console.log('Error: ', err);
                });
        },
        getApiDeleteUrl: function () {
            return BASE_URL + 'rest/V1/bookmarks_bookmark/' + this.currentBookmarkId;
        },
        toggleStar: function () {
            let star = $('#bookmark-star');

            if (star[0].classList.contains('star-red')) {
                // is active
                star.removeClass('star-red');
                star.addClass('star');
            } else {
                star.removeClass('star');
                star.addClass('star-red');
            }
        }

    });
});
