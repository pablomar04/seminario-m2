define(
    [
        'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Tudai_CuentaCorriente/payment/customer_credit'
            }
        });
    }
);