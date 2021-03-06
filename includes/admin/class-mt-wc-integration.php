<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WooCommerce integration for Marketplace Taxes.
 *
 * Adds a marketplace settings page under WooCommerce > Settings > Integration >
 * Marketplace Taxes.
 */
class MT_WC_Integration extends WC_Integration implements MT_Settings_API {

    /**
     * Constructor.
     */
    public function __construct() {
        $this->id                 = 'marketplace_taxes';
        $this->method_title       = __( 'Marketplace Taxes', 'marketplace-taxes' );
        $this->method_description = $this->get_method_description();

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );

        $this->init_form_fields();
    }

    /**
     * Enqueues the scripts for the admin options screen.
     */
    public function enqueue_scripts() {
        $screen = get_current_screen();
        $tab    = isset( $_GET['tab'] ) ? $_GET['tab'] : '';

        if ( 'woocommerce_page_wc-settings' === $screen->id && 'integration' === $tab ) {
            MT()->assets->enqueue( 'script', 'marketplace-taxes.input-toggle' );
        }
    }

    /**
     * Returns the description displayed on the settings page.
     *
     * @return string
     */
    public function get_method_description() {
        $paragraphs = [
            __( 'Use this page to configure sales tax automation for your marketplace.', 'marketplace-taxes' ),
            __(
                'Need help? Check out the <a href="https://thepluginpros.com/documentation/taxjar">documentation</a>',
                'marketplace-taxes'
            ),
        ];

        return '<p>' . implode( '</p><p>', $paragraphs ) . '</p>';
    }

    /**
     * Initializes the settings form fields.
     */
    public function init_form_fields() {
        $this->form_fields = [
            'enabled'             => [
                'title'   => __( 'Enable', 'marketplace-taxes' ),
                'type'    => 'checkbox',
                'label'   => __( 'Enable automated tax calculations', 'marketplace-taxes' ),
                'default' => 'yes',
            ],
            'api_token'           => array_merge(
                MT_Field_API_Token::init( $this ),
                [
                    'desc_tip'          => __(
                        'Your API token will be used to calculate the correct tax rate at checkout.',
                        'marketplace-taxes'
                    ),
                    'custom_attributes' => [
                        'required' => 'required',
                    ],
                ]
            ),
            'merchant_of_record'  => [
                'title'       => __( 'Seller of record', 'marketplace-taxes' ),
                'type'        => 'select',
                'class'       => 'input-toggle',
                'options'     => [
                    'vendor'      => __( 'Vendor', 'marketplace-taxes' ),
                    'marketplace' => __( 'Marketplace', 'marketplace-taxes' ),
                ],
                'default'     => 'vendor',
                'description' => __(
                    'The seller of record is responsible for collecting and remitting sales tax for each sale. The tax collected at checkout will be given to the seller of record.',
                    'marketplace-taxes'
                ),
                'desc_tip'    => true,
            ],
            'nexus_addresses'     => array_merge(
                MT_Field_Business_Locations::init( $this ),
                [
                    'title'         => __( 'Business locations', 'marketplace-taxes' ),
                    'wrapper_class' => 'show-if-woocommerce_marketplace_taxes_merchant_of_record-marketplace',
                ]
            ),
            'upload_transactions' => MT_Field_Upload_Orders::init( $this ),
        ];
    }

    /**
     * Outputs the admin options screen with any validation errors.
     */
    public function admin_options() {
        parent::display_errors();

        parent::admin_options();
    }

    /**
     * Saves the options entered by the user.
     */
    public function process_admin_options() {
        parent::process_admin_options();

        do_action( 'marketplace_taxes_options_saved', $this );
    }

    /**
     * Generates the HTML for a custom field.
     *
     * @param string $key
     * @param array  $field
     *
     * @return string
     */
    public function generate_custom_field_html( $key, $field ) {
        $field_key = $this->get_field_key( $key );
        $defaults  = [
            'title'         => '',
            'desc_tip'      => false,
            'description'   => '',
            'wrapper_class' => '',
            'value'         => MT()->addresses->get( MT_Vendors::MARKETPLACE ),
        ];

        $field = wp_parse_args( $field, $defaults );

        ob_start();
        ?>
        <tr valign="top" class="<?php echo esc_attr( $field['wrapper_class'] ); ?>">
            <th scope="row" class="titledesc">
                <label for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post(
                        $field['title']
                    ); ?><?php echo $this->get_tooltip_html( $field ); ?></label>
            </th>
            <td class="forminp">
                <?php
                // Make all field attributes available in the included file
                extract( $field );

                include_once( $field['path'] );

                echo $this->get_description_html( $field );
                ?>
            </td>
        </tr>
        <?php

        return ob_get_clean();
    }

    /**
     * Gets the user's TaxJar API token.
     *
     * @return string
     */
    public function get_api_token() {
        if ( $_POST ) {
            return $this->get_field_value( 'api_token', $this->form_fields['api_token'] );
        }

        return $this->get_option( 'api_token' );
    }

    /**
     * Checks whether sales tax reporting is enabled.
     *
     * @return bool
     */
    public function is_reporting_enabled() {
        if ( 'vendor' === $this->get_option( 'merchant_of_record' ) ) {
            return false;
        }

        return 'yes' === $this->get_option( 'upload_transactions' );
    }

    /**
     * Checks whether an API token is required based on the user's settings.
     *
     * @return bool
     */
    public function is_token_required() {
        return true;
    }

    /**
     * Checks whether addresses are required based on the user's settings.
     *
     * @return bool
     */
    public function addresses_required() {
        return 'marketplace' === $this->get_option( 'merchant_of_record' );
    }

    /**
     * Gets the default addresses for the Business Locations table.
     *
     * @return int
     */
    public function get_vendor_id() {
        return MT_Vendors::MARKETPLACE;
    }

}
