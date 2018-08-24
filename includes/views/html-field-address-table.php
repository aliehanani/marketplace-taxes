<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>
<div class="control-group">
    <label for="wcv_taxes_nexus_addresses"><?php _e( 'Business Locations <small>Required</small>', 'taxjar-for-marketplaces' ); ?></label>
    
    <div class="control">
        <table id="wcv_taxes_nexus_addresses_table">
            <thead> 
                <tr>
                    <th><?php _e( 'Address 1', 'taxjar-for-marketplaces' ); ?></th>
                    <th><?php _e( 'Address 2', 'taxjar-for-marketplaces' ); ?></th>
                    <th><?php _e( 'Country', 'taxjar-for-marketplaces' ); ?></th>
                    <th><?php _e( 'State', 'taxjar-for-marketplaces' ); ?></th>
                    <th><?php _e( 'City', 'taxjar-for-marketplaces' ); ?></th>
                    <th><?php _e( 'Postcode', 'taxjar-for-marketplaces' ); ?></th>
                    <th width="30"><!-- Actions --></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="7">
                        <button type="button" class="vt-add-nexus-address"><?php _e( 'Add Address', 'taxjar-for-marketplaces' ); ?></button>
                    </th>
                </tr>
            </tfoot>
            <tbody id="wcv_taxes_nexus_addresses">
                <!-- Placeholder -->
            </tbody>
        </table>

        <!-- Used to validate Business Locations field -->
        <input type="text" name="locations_placeholder" id="locations_placeholder" class="wcv-tax-hidden">
    </div>
    
    <p class="tip">
        <?php esc_html_e( 'Please enter all locations, including stores, warehouses, distribution facilities, etc.', 'taxjar-for-marketplaces' ); ?>
    </p>
</div>

<script type="text/html" id="tmpl-vt-nexus-addresses-empty">
    <tr id="wcv_taxes_nexus_addresses_blank_row">
        <td colspan="7">
            <p><?php printf( '%s <a href="#" class="vt-add-nexus-address">%s</a>', __( 'No addresses entered.', 'taxjar-for-marketplaces' ), __( 'Add one.', 'taxjar-for-marketplaces' ) ); ?></p>
        </td>
    </tr>
</script>

<script type="text/html" id="tmpl-vt-nexus-address">
    <tr data-id="{{ data.id }}">
        <td>
            <input type="text" name="wcv_taxes_nexus_addresses[{{ data.id }}][address_1]" id="wcv_taxes_nexus_addresses[{{ data.id }}][address_1]" placeholder="<?php esc_attr_e( 'Street address', 'taxjar-for-marketplaces' ); ?>" value="{{ data.address_1 }}">
        </td>
        <td>
            <input type="text" name="wcv_taxes_nexus_addresses[{{ data.id }}][address_2]" id="wcv_taxes_nexus_addresses[{{ data.id }}][address_2]" placeholder="<?php esc_attr_e( 'Apartment, suite, etc.', 'taxjar-for-marketplaces' ); ?>" value="{{ data.address_2 }}">
        </td>
        <td>    
            <select name="wcv_taxes_nexus_addresses[{{ data.id }}][country]" id="wcv_taxes_nexus_addresses[{{ data.id }}][country]" class="select2 country_to_state country_select">
                <?php foreach ( $countries as $code => $name ): ?>
                    <option value="<?php echo $code; ?>"><?php echo $name; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <input type="text" name="wcv_taxes_nexus_addresses[{{ data.id }}][state]" id="wcv_taxes_nexus_addresses[{{ data.id }}][state]" class="shipping_state" placeholder="<?php esc_attr_e( 'State', 'taxjar-for-marketplaces' ); ?>" value="{{ data.state }}">
        </td>
        <td>
            <input type="text" name="wcv_taxes_nexus_addresses[{{ data.id }}][city]" id="wcv_taxes_nexus_addresses[{{ data.id }}][city]" placeholder="<?php esc_attr_e( 'City', 'taxjar-for-marketplaces' ); ?>" value="{{ data.city }}">
        </td>
        <td>
            <input type="text" name="wcv_taxes_nexus_addresses[{{ data.id }}][postcode]" id="wcv_taxes_nexus_addresses[{{ data.id }}][postcode]" placeholder="<?php esc_attr_e( 'Postcode', 'taxjar-for-marketplaces' ); ?>" value="{{ data.postcode }}">
        </td>
        <td width="30">
            <a href="#" class="vt-remove-nexus-address" title="Remove">
                <i class="fa fa-times"></i>
            </a>
        </td>
    </tr>
</script>