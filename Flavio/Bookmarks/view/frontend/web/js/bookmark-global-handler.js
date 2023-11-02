define([
    'uiComponent',
    'ko',
    'underscore',
    'jquery'
], function(
    Component,
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
            currentUserId: ''
        },
        initialize: function(config) {
            this._super();

            this.currentPageTitle = config.currentPageTitle;
            this.currentPageUrl = config.currentPageUrl;
            console.log(this.name + ' is initialized.');
        },
        updateBookmark: function () {
            this.toggleStar();
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
