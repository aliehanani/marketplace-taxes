<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/../../admin/class-tfm-admin-notices.php';

/**
 * Class TFM_WC_Vendors_Admin_Notices
 *
 * Provides functions for displaying notices in WP admin.
 */
class TFM_WC_Vendors_Admin_Notices extends TFM_Admin_Notices {

    /**
     * Constructor.
     */
    public static function init() {
        parent::$core_notices = array_merge(
            parent::$core_notices,
            [
                'sub_order_update' => array( __CLASS__, 'update_notice' ),
            ]
        );

        parent::init();
    }

    /**
     * If we need to update, include a message with the update button.
     */
    public static function update_notice() {
        if ( ! get_option( 'tfm_sub_orders_updated' ) ) {
            $updater = new TFM_WC_Vendors_Order_Updater();
            if ( $updater->is_updating() || ! empty( $_GET['tfm_update_sub_orders'] ) ) {
                include( 'views/notices/html-notice-updating.php' );
            } else {
                include( 'views/notices/html-notice-update.php' );
            }
        } else {
            include( 'views/notices/html-notice-updated.php' );
        }
    }

}

TFM_WC_Vendors_Admin_Notices::init();
