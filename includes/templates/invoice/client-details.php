<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * Get client details
 *
 * @since      1.0.0
 */

$client_details = array();
foreach ( get_post_meta( $client_id ) as $key => $value ) {
	$client_details[ $key ] = $value[0];
}

$client_name      = get_the_title( $client_id );
$client_address_1 = wp_kses( $client_details['_cli_address_1'], 'strip' );
$client_address_2 = wp_kses( $client_details['_cli_address_2'], 'strip' );
$client_city      = wp_kses( $client_details['_cli_city'], 'strip' );
$client_country   = csip\admin\Helpers::get_country_name( $client_details['_cli_country'] );
$client_state     = $client_details['_cli_state'];
$client_zip       = wp_kses( $client_details['_cli_zip'], 'strip' );
$client_tax_rate  = $client_details['_cli_tax_rate'];

$client_currency = $client_details['_cli_currency']
					? $client_details['_cli_currency']
					: $fallback_currency;

$client_city_zip = $client_zip
				? ( $client_city . ', ' . $client_zip )
				: $client_city;

$client_country_state = $client_state
						? ( $client_country . ', ' . $client_state )
						: $client_country;

?>

<ul class="csip-invoice-list">
	<li class="csip-invoice-list-label"><?php _e( 'Bill to', 'invoiceit' ); ?></li>
	<?php if ( $client_name ) : ?>
		<li class="csip-invoice-list-entry csip-client-name"><?php echo $client_name; ?></li>
	<?php endif; ?>
	<?php if ( $client_address_1 ) : ?>
		<li class="csip-invoice-list-entry"><?php echo $client_address_1; ?></li>
	<?php endif; ?>
	<?php if ( $client_address_2 ) : ?>
		<li class="csip-invoice-list-entry"><?php echo $client_address_2; ?></li>
	<?php endif; ?>
	<?php if ( $client_city_zip ) : ?>
		<li class="csip-invoice-list-entry"><?php echo $client_city_zip; ?></li>
	<?php endif; ?>
	<?php if ( $client_country_state ) : ?>
		<li class="csip-invoice-list-entry"><?php echo $client_country_state; ?></li>
	<?php endif; ?>
</ul>
