<?php

wp_head();

global $wpdb;

/**
 * Set allowed html tags fields
 */
$allowed_html = array(
	'b' => array(),
	'i' => array(),
);


/**
 * Get company details
 *
 * @since      1.0.0
 */
$wp_options_company = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options WHERE (CONVERT(`option_name` USING utf8) LIKE '%csip_%')", ARRAY_A );

$company_details = array();
foreach ( $wp_options_company as $value ) {
	$company_details[ $value['option_name'] ] = $value['option_value'];
}

$signature_url = $company_details['_csip_company_signature'];
$company_terms = wpautop( wp_kses( $company_details['_csip_company_terms'], $allowed_html ) );
$company_note  = wpautop( wp_kses( $company_details['_csip_company_note'], $allowed_html ) );
$footertext    = wpautop( wp_kses( $company_details['_csip_company_footertext'], $allowed_html ) );



/**
 * Get invoice details
 */
$invoice_details = array();
foreach ( get_post_meta( get_the_ID() ) as $key => $value ) {
	$invoice_details[ $key ] = $value[0];
}

$invoice_payment_account = intval( $invoice_details['_inv_payment_account'] );
$signature_show          = intval( $invoice_details['_inv_payment_signature'] );
$account_id              = carbon_get_post_meta( get_the_ID(), 'inv_payment_account' );
$invoice_comment         = wp_kses( $invoice_details['_inv_comment'], 'strip' );


/**
 * Set some defaults in case no client is selected
 */
$fallback_tax_rate = $company_details['_csip_company_fallback_tax_rate']
					? $company_details['_csip_company_fallback_tax_rate']
					: 0;
$fallback_currency = ( '0' !== $company_details['_csip_company_fallback_currency'] )
					? $company_details['_csip_company_fallback_currency']
					: 'USD';

?>


<div class="csip-container">
	<section class="csip-invoice">

		<header class="csip-invoice-header csip-block csip-mb-40">
			<div class="csip-row">
				<?php require CSIP_PATH . '/includes/templates/invoice/company-details.php'; ?>
			</div>
		</header>


		<article>

			<div class="csip-row csip-invoice-info csip-mb-40">

				<div class="csip-span-8 csip-invoice-name-info">
					<?php require CSIP_PATH . '/includes/templates/invoice/invoice-details.php'; ?>
				</div>

				<?php if ( $client_id ) : ?>
				<div class="csip-span-4 csip-invoice-billto">
					<?php require CSIP_PATH . '/includes/templates/invoice/client-details.php'; ?>
				</div>
				<?php endif; ?>

			</div>

			<div class="csip-invoice-items">
				<?php require CSIP_PATH . '/includes/templates/invoice/table.php'; ?>
			</div>

			<?php if ( $signature_url && $signature_show ) : ?>
				<div class="csip-invoice-signature csip-avoid-break csip-px-6">
					<p class="csip-text-right"><?php _e( 'Signature', 'invoiceit' ); ?></p>
					<div class="thumb">
						<span style="background-image: url(<?php echo $signature_url; ?>)"></span>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $account_id ) : ?>
				<div class="csip-invoice-payment-account csip-mb-40 csip-avoid-break csip-px-6">
				<?php require CSIP_PATH . '/includes/templates/invoice/payment-account-details.php'; ?>
				</div>
			<?php endif; ?>

			<?php if ( $invoice_comment ) { ?>
			<div class="csip-invoice-note csip-mb-40 csip-avoid-break csip-px-6">
				<h3 class="csip-invoice-title-underlined">
					<?php _e( 'Invoice Note', 'invoiceit' ); ?>
				</h3>
				<?php echo wpautop( wp_kses( $invoice_comment, 'post' ) ); ?>
			</div>
			<?php } ?>

		</article>

		<?php if ( $company_terms ) : ?>
		<div class="csip-mb-30 csip-avoid-break csip-px-6">
			<h3 class="csip-invoice-title-underlined">
				<?php _e( 'Terms & Conditions', 'invoiceit' ); ?>
			</h3>
			<div class="csip-invoice-note">
				<?php echo $company_terms; ?>
			</div>
		</div>
		<?php endif; ?>

		<?php if ( $company_note ) : ?>
		<div class="csip-mb-30 csip-avoid-break csip-px-6">
			<h3 class="csip-invoice-title-underlined">
				<?php _e( 'Note', 'invoiceit' ); ?>
			</h3>
			<div class="csip-invoice-note">
				<?php echo $company_note; ?>
			</div>
		</div>
		<?php endif; ?>

		<?php if ( $footertext ) : ?>
		<div class="csip-invoice-footer">
			<?php echo $footertext; ?>
		</div>
		<?php endif; ?>

	</section>
</div>

<?php
wp_footer();