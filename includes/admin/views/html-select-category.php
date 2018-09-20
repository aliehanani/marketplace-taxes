<?php

/**
 * Tax category select box template.
 *
 * @global string $selected_category
 * @global bool $is_variation
 * @global int $product_id
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( $is_variation ) {
    $class = 'form-row form-field form-row-full variation-category';
} else {
    $class = 'form-field';
} ?>

    <p class="<?php echo $class; ?> tax-category">
        <label for="tax_category[<?php echo $product_id; ?>]">
            <?php
            _e( 'Tax category', 'taxjar-for-marketplaces' );

            echo wc_help_tip(
                __(
                    'Used for products that are either exempt from tax in some jurisdictions or are taxed at reduced rates. ',
                    'taxjar-for-marketplaces'
                )
            );
            ?>
        </label>

        <span class="tfm-selected-category"><?php esc_html_e(
                'None',
                'taxjar-for-marketplaces'
            ); ?></span>

        <button type="button" class="button tfm-select-category"
                data-is-variation="<?php echo (int) $is_variation; ?>"><?php esc_html_e(
                'Change',
                'taxjar-for-marketplaces'
            ); ?></button>

        <button type="button" class="button tfm-reset-category"><?php esc_html_e(
                'Reset',
                'taxjar-for-marketplaces'
            ); ?></button>

        <input type="hidden" name="tax_category[<?php echo $product_id; ?>]" class="tfm-category-input"
               value="<?php echo $selected_category; ?>">
    </p>

<?php include __DIR__ . '/html-tax-category-modal.php'; ?>