let config = {
    deps: [
        'Flavio_CustomCheckout/js/mask-telephone-inputs'
    ],
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Flavio_CustomCheckout/js/action/set-shipping-information-mixin': true
            }
        }
    }
};
