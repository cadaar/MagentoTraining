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
            currentPageUrl: '',
            currentBookmarkId: 0,
        },
        initialize: function() {
            this._super();

            this.currentPageUrl = window.location.href;
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
                .get(`${this.getApiUrl()}url/${encodeURIComponent(this.currentPageUrl)}`)
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
        addBookmark: function () {
            let bookmark = {
                page_title: document.title,
                url: this.currentPageUrl,
            };
            storage
                .post(
                    this.getApiUrl(),
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
        deleteBookmark: function () {
            storage
                .delete(
                    `${this.getApiUrl()}${encodeURIComponent(this.currentBookmarkId)}`
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
        getApiUrl: function () {
            return `${BASE_URL}rest/V1/bookmarks_bookmark/`;
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
