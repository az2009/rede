/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (Component, rendererList) {
        'use strict';
        rendererList.push({
            type: 'az2009_cielo_dc',
            component: 'Az2009_Cielo/js/view/payment/method-renderer/az2009_cielo_dc-method'
        });

        /** Add view logic here if needed */
        return Component.extend({});
    });
