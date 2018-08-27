<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class TFM_Settings_API
 *
 * Common settings API implemented by the WC integration and vendor settings form.
 */
interface TFM_Settings_API {

    /**
     * Gets an option from the DB, using defaults if necessary to prevent undefined notices.
     *
     * @param string $key Option key.
     * @param mixed $empty_value Value when empty.
     *
     * @return string The value specified for the option or a default value for the option.
     */
    function get_option( $key, $empty_value = null );

    /**
     * Gets the user's TaxJar API token.
     *
     * @return string
     */
    function get_api_token();

    /**
     * Checks whether sales tax reporting is enabled.
     *
     * @return bool
     */
    function is_reporting_enabled();

    /**
     * Gets the store URL to send to TaxJar.
     *
     * @return string
     */
    function get_store_url();

}
