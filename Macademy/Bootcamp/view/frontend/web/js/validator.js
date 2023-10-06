define([
    'uiComponent',
    'ko',
    'mage/url',
    'mage/storage',
    'mage/translate',
], function (
    Component,
    ko,
    url,
    storage,
    $t
) {
    'use strict';

    return Component.extend({
        defaults: {
            placeholder: $t('Some text goes here...'),
            textToValidate: ko.observable(''),
            messageResponse: ko.observable(''),
            isSuccess: ko.observable(false)
        },
        initialize (){
            this._super();
            this.messageResponse('');
            console.log(this.name + ' component is initialized.')
        },
        handleSubmit: function () {
            this.messageResponse('');
            this.isSuccess(false);
            console.log('Submit was initiated.')
            console.log('Payload: ' + ko.toJSON(this.textToValidate()));

            let jsonData = ko.toJSON(this.textToValidate())

            console.log(this.getUrl());

            storage
                .post(
                    this.getUrl(), 
                        ko.toJSON(this.textToValidate()), true, 'application/json'
                        
        )
                .done(response => {
                    console.log('Response: ', response);
                    this.isSuccess(response.success);
                    this.messageResponse(response.success? 'Éxito': 'Fallo');
                })
                .fail(err => {
                    console.log('Error: ', err);
                    this.messageResponse('Submit ERR');
                });
        },
        getUrl() {
            return url.build('bootcamp/index/post');
        }

    })

});
