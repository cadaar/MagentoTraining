define([
    'uiComponent',
    'ko'
], function(
    Component,
    ko
) {
    'use strict';

    return Component.extend({

        defaults: {
            counterValue: ko.observable(0)
        },
        initialize() {
            this._super();

            console.log('The Counter component has been loaded.');
        },
        add() {
            this.counterValue(parseInt(this.counterValue()) + 1);
        },
        subtract() {
            this.counterValue(parseInt(this.counterValue()) - 1);
        }

    });
});
