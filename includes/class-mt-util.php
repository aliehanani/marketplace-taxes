<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Utilities.
 *
 * A collection of static helper functions used during tax calculations.
 *
 * @author  Brett Porcelli
 * @package Marketplace_Taxes
 */
class MT_Util {

    /**
     * Validates a TaxJar API token by fetching a list of tax categories.
     *
     * @param string $token
     *
     * @return string
     *
     * @throws Exception If validation fails
     */
    public static function validate_api_token( $token ) {
        $client = MT()->client( $token );

        try {
            $client->categories();
        } catch ( TaxJar\Exception $ex ) {
            if ( 401 === $ex->getStatusCode() ) {
                throw new Exception( __( 'The provided API token is invalid.', 'marketplace-taxes' ) );
            } else {
                throw new Exception( __( 'Error connecting to TaxJar.', 'marketplace-taxes' ) );
            }
        }

        return $token;
    }

    /**
     * Gets the tax code for a product.
     *
     * @param int $product_id
     *
     * @return string
     */
    public static function get_product_tax_code( $product_id ) {
        $product  = wc_get_product( $product_id );
        $tax_code = $product->get_meta( 'tax_category', true );

        if ( empty( $tax_code ) && is_a( $product, 'WC_Product_Variation' ) ) {
            $parent   = wc_get_product( $product->get_parent_id() );
            $tax_code = $parent->get_meta( 'tax_category', true );
        }

        // The 'General' tax code (00000) is not officially supported by TaxJar.
        // If it's selected, return the empty string.
        if ( '00000' === $tax_code ) {
            $tax_code = '';
        }

        return $tax_code;
    }

}
