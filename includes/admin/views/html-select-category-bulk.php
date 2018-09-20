<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

    <label class="alignleft">
        <span class="title"><?php _e( 'Tax category', 'taxjar-for-marketplaces' ); ?></span>
        <span class="input-text-wrap">
            <span class="tfm-selected-category"><?php esc_html_e(
                    'No change',
                    'taxjar-for-marketplaces'
                ); ?></span>
            <input type="hidden" name="tax_category" class="tfm-category-input" value="">
            <button type="button" class="button button tfm-select-category" data-is-bulk="1"><?php esc_html_e(
                    'Change',
                    'taxjar-for-marketplaces'
                ); ?></button>
            <button type="button" class="button tfm-reset-category"><?php esc_html_e(
                    'Reset',
                    'taxjar-for-marketplaces'
                ); ?></button>
        </span>
    </label>

<?php include __DIR__ . '/html-tax-category-modal.php'; ?>