define([
    'uiComponent',
    'mage/storage',
    'ko',
    'underscore',
], function(
    Component,
    storage,
    ko,
    _
) {
    'use strict';

    return Component.extend({

        defaults: {
            template: 'Flavio_CatFact/cat-fact-banner',
            message: 'Cats can drink sea water in order to survive.'
        },
        initialize: function() {
            this._super();

            this.fillCatFactMessage();

            console.log(this.name + ' is initialized.')
        },
        fillCatFactMessage: function () {
            // storage
            //     .get(
            //         'https://meowfacts.herokuapp.com',
            //     )
            //     .done(response => {
            //         console.log(response);
            //         this.message('Hola mundo');
            //     })
            //     .fail(err => {
            //         console.log('Error: ', err);
            //     });
        }

    });
});
