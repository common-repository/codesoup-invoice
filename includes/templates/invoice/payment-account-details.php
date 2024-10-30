<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * Get payment account details
 *
 * @since      1.0.0
 */

$account_details_1 = get_post_meta( $account_id, '_csip_company_account_details', true );
$account_details_2 = get_post_meta( $account_id, '_csip_company_account_details_other', true );

if ( $account_details_1 || $account_details_2 ) : ?>

	<h3 class="csip-invoice-title-underlined">
		<?php _e( 'Ways to pay', 'invoiceit' ); ?>
	</h3>

	<div class="csip-invoice-account csip-mb-30">
		<h4 class="csip-invoice-account-name"><?php echo get_the_title( $account_id ); ?></h4>
		<div class="csip-row">
			<?php if ( $account_details_1 ) : ?>
				<div class="csip-span-6">
					<?php echo wpautop( wp_kses( $account_details_1, $allowed_html ) ); ?>
				</div>
			<?php endif; ?>
			<?php if ( $account_details_2 ) : ?>
				<div class="csip-span-6">
					<?php echo wpautop( wp_kses( $account_details_2, $allowed_html ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php
endif;
