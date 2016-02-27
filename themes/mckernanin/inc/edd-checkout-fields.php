<?php
/**
 * Adding a custom field to the checkout screen
 *
 * Covers:
 *
 * Adding a website address field to the checkout
 * Making the website address field required
 * Setting an error when the website address field is not filled out
 * Storing the website address into the payment meta
 * Adding the customer's website address to the "view order details" screen
 * Adding a new {site_url} email tag so you can display the website address in the email notifications (standard purchase receipt or admin notification)
 *
 * @package mckernanin
 */

/**
 * Display website address field at checkout
 * Add more here if you need to
 */
function mck_edd_display_checkout_fields() {
?>
	<p id="edd-site-url-wrap">
		<label class="edd-label" for="edd-site-url">
			<?php echo 'Website Address'; ?>
		</label>
		<span class="edd-description">
			<?php echo 'Enter the website address this hosting plan is for.'; ?>
		</span>
		<input class="edd-input" type="text" name="edd_site_url" id="edd-site-url" placeholder="<?php echo 'website address'; ?>" />
	</p>
	<?php
}
add_action( 'edd_purchase_form_user_info_fields', 'mck_edd_display_checkout_fields' );

/**
 * Make website address required
 * Add more required fields here if you need to
 *
 * @param array $required_fields Required fields.
 */
function mck_edd_required_checkout_fields( $required_fields ) {
	$required_fields = array(
		'edd_site_url' => array(
			'error_id' => 'invalid_site_url',
			'error_message' => 'Please enter a valid website address',
		),
	);

	return $required_fields;
}
add_filter( 'edd_purchase_form_required_fields', 'mck_edd_required_checkout_fields' );

/**
 * Set error if website address field is empty
 * You can do additional error checking here if required
 */
function mck_edd_validate_checkout_fields( $valid_data, $data ) {
	if ( empty( $data['edd_site_url'] ) ) {
		edd_set_error( 'invalid_site_url', 'Please enter your website address.' );
	}
}
add_action( 'edd_checkout_error_checks', 'mck_edd_validate_checkout_fields', 10, 2 );

/**
 * Store the custom field data into EDD's payment meta
 */
function mck_edd_store_custom_fields( $payment_meta ) {
	$payment_meta['site_url'] = isset( $_POST['edd_site_url'] ) ? sanitize_text_field( $_POST['edd_site_url'] ) : '';

	return $payment_meta;
}
add_filter( 'edd_payment_meta', 'mck_edd_store_custom_fields' );


/**
 * Add the website address to the "View Order Details" page
 */
function mck_edd_view_order_details( $payment_meta, $user_info ) {
	$site_url = isset( $payment_meta['site_url'] ) ? $payment_meta['site_url'] : 'none';
?>
	<div class="column-container">
		<div class="column">
			<strong><?php echo 'Website Address: '; ?></strong>
			 <?php echo $site_url; ?>
		</div>
	</div>
<?php
}
add_action( 'edd_payment_personal_details_list', 'mck_edd_view_order_details', 10, 2 );

/**
 * Add a {site_url} tag for use in either the purchase receipt email or admin notification emails
 */
edd_add_email_tag( 'site_url', 'Customer\'s website address', 'mck_edd_email_tag_site_url' );

/**
 * The {site_url} email tag
 */
function mck_edd_email_tag_site_url( $payment_id ) {
	$payment_data = edd_get_payment_meta( $payment_id );
	return $payment_data['site_url'];
}
