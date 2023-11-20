<?php
/**
 * First file needed . File required for the plugin activation 
 */
if(!'ABSPATH') {
    return;
}

function possa_woocommerce_check () {
    if( class_exists('WooCommerce')) {
        
        if(is_plugin_active('woocommerce/woocommerce.php')) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
    
}