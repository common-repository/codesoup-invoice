<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * Display table with invoice items
 *
 * @since      1.0.0
 */

$subtotal = $discount = $tax_duty = $total = 0;
$items    = carbon_get_the_post_meta( 'inv_items' );


$invoice_currency = isset( $client_currency )
					? $client_currency
					: $fallback_currency;
$invoice_tax_rate = isset( $client_tax_rate )
					? $client_tax_rate
					: $fallback_tax_rate;

// Handle currency formatting.
$fmt = new NumberFormatter( get_locale(), NumberFormatter::CURRENCY );
$fmt->setTextAttribute( NumberFormatter::CURRENCY_CODE, $invoice_currency );
$fmt->setAttribute( NumberFormatter::FRACTION_DIGITS, 2 );

if ( $items ) : ?>

<table class="csip-invoice-table">
	<thead>
		<tr>
			<th class="csip-text-left"><?php _e( 'Item', 'invoiceit' ); ?></th>
			<th class="csip-text-center"><?php _e( 'Quantity', 'invoiceit' ); ?></th>
			<th class="csip-text-center"><?php _e( 'Unit', 'invoiceit' ); ?></th>
			<th class="csip-text-center"><?php _e( 'Rate', 'invoiceit' ); ?></th>
			<th class="csip-text-center"><?php _e( 'Discount (%)', 'invoiceit' ); ?></th>
			<th class="csip-text-center"><?php _e( 'Amount', 'invoiceit' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $items as $item ) : ?>

			<tr>
				<td class="csip-invoice-table-entry csip-text-left">
					<dl class="csip-invoice-table-item-desc">
						<dt><?php echo wp_kses( $item['inv_item_title'], 'strip' ); ?></dt>
						<dd><?php echo wpautop( wp_kses( $item['inv_item_description'], 'strip' ) ); ?></dd>
					</dl>
				</td>
				<td class="csip-invoice-table-entry csip-text-center">
					<?php echo $item['inv_item_quantity']; ?>
				</td>
				<td class="csip-invoice-table-entry csip-text-center">
					<?php echo wp_kses( $item['inv_item_um'], 'strip' ); ?>
				</td>
				<td class="csip-invoice-table-entry csip-text-center">
					<?php echo $fmt->formatCurrency( $item['inv_item_rate'], $invoice_currency ); ?>
				</td>
				<td class="csip-invoice-table-entry csip-text-center">
					<?php
						$item_discount = $item['inv_item_discount']
										? $item['inv_item_discount']
										: 0;
						echo $item_discount;
					?>
				</td>
				<td class="csip-invoice-table-entry csip-text-center">
					<?php echo $fmt->formatCurrency( $item['inv_item_amount'], $invoice_currency ); ?>
				</td>
			</tr>

			<?php
			$subtotal += $item['inv_item_quantity'] * $item['inv_item_rate'];
			$discount += ( $item['inv_item_quantity'] * $item['inv_item_rate'] ) - $item['inv_item_amount'];
			$total    += $item['inv_item_amount'];

		endforeach;

		if ( $invoice_tax_rate > 0 ) {
			$tax_duty = $total / ( 100 / $invoice_tax_rate );
			$total += $tax_duty;
		}

		?>
	</tbody>
	<tfoot>
		<tr class="csip-invoice-table-row-subtotal">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-left">
				<?php _e( 'Subtotal', 'invoiceit' ); ?>
			</td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-right">
				<?php echo $fmt->formatCurrency( $subtotal, $invoice_currency ); ?>
			</td>
		</tr>
		<tr class="csip-invoice-table-row-discount">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-left">
				<?php _e( 'Discount', 'invoiceit' ); ?>
			</td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-right">
				<?php echo $fmt->formatCurrency( $discount, $invoice_currency ); ?>
			</td>
		</tr>
		<tr class="csip-invoice-table-row-tax">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-left">
				<?php echo __( 'Tax', 'invoiceit' ) . ' (' . $invoice_tax_rate . '%)'; ?>
			</td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-right">
				<?php echo $fmt->formatCurrency( $tax_duty, $invoice_currency ); ?>
			</td>
		</tr>
		<tr class="csip-invoice-table-row-total">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-left">
				<?php _e( 'TOTAL', 'invoiceit' ); ?>
			</td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-right">
				<?php echo $fmt->formatCurrency( $total, $invoice_currency ); ?>
			</td>
		</tr>
	</tfoot>
</table>

	<?php
endif;
