define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'customer_credit',
                component: 'Tudai_CuentaCorriente/js/view/payment/method-renderer/customer_credit'
            }
        );
        return Component.extend({});
    }
);