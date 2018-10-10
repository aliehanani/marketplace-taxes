<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class MT_API
 *
 * Registers our custom WC REST API controller with WooCommerce.
 */
class MT_API {

    public function __construct() {
        add_filter( 'woocommerce_api_classes', array( $this, 'register_api_class' ) );
    }

    /**
     * Replaces the WC legacy orders controller with our own implementation.
     *
     * This is required for TaxJar reporting to work correctly.
     *
     * @param array $classes
     *
     * @return array
     */
    public function register_api_class( $classes ) {
        $key = array_search( 'WC_API_Orders', $classes );

        if ( false !== $key ) {
            unset( $classes[ $key ] );
        }

        require_once __DIR__ . '/class-mt-api-orders.php';

        $classes[] = 'MT_API_Orders';

        return $classes;
    }

}

new MT_API();