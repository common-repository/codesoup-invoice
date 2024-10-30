<?php

namespace csip\admin\fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly.
defined( 'WPINC' ) || die;


/**
 * Class containing fields for the Invoice post-type
 *
 * @since    1.0.0
 */
class Invoice {


	/**
	 * Load all custom field metaboxes for the Invoice post-type
	 *
	 * @since    1.0.0
	 */
	public static function load() {
		self::fields_general();
		self::fields_items();
		self::fields_note();
	}


	/**
	 * Create general fields
	 *
	 * @since    1.0.0
	 */
	private static function fields_general() {
		Container::make( 'post_meta', __( 'General', 'invoiceit' ) )
			->where( 'post_type', '=', 'invoice' )
			->add_fields(
				array(
					Field::make( 'text', 'inv_number', __( 'Invoice Number', 'invoiceit' ) )
						->set_attribute( 'readOnly', true )
						->set_default_value( \csip\admin\Helpers::get_next_invoice_number() )
						->set_classes( 'span-4 inv-number' ),
					Field::make( 'select', 'inv_client', __( 'Client', 'invoiceit' ) )
						->set_options( \csip\admin\Helpers::get_clients() )
						->set_classes( 'span-4 inv-client csip-select2' ),
					Field::make( 'select', 'inv_status', __( 'Invoice Status', 'invoiceit' ) )
						->set_options(
							array(
								''                   => __( '-- Please Select', 'invoiceit' ),
								'inv_outstanding'    => _x( 'Outstanding', 'Invoice stauts', 'invoiceit' ),
								'inv_paid'           => _x( 'Paid', 'Invoice stauts', 'invoiceit'  ),
								'inv_partially_paid' => _x( 'Partially Paid', 'Invoice stauts', 'invoiceit' ),
							)
						)
						->set_classes( 'span-4 inv-status csip-select2' ),
					Field::make( 'date', 'inv_date', __( 'Invoice Date', 'invoiceit' ) )
						->set_classes( 'span-4 inv-date' ),
					Field::make( 'number', 'inv_net_period', _x( 'Net', 'The period of time between an invoice is issued and the date payment is due', 'invoiceit' ) )
						->set_min( 0 )
						->set_classes( 'span-4 inv-net-period' )
						->set_help_text( 'Days until the payment is due' ),
					Field::make( 'date', 'inv_due_date', __( 'Invoice Due Date', 'invoiceit' ) )
						->set_classes( 'span-4 inv-due-date' ),
					Field::make( 'select', 'inv_payment_account', __( 'Payment Account', 'invoiceit' ) )
						->set_options( \csip\admin\Helpers::get_accounts() )
						->set_classes( 'span-8 inv-payment-account csip-select2' ),
					Field::make( 'checkbox', 'inv_payment_signature', __( 'Show Signature', 'invoiceit' ) )
						->set_option_value( '1' )
						->set_classes( 'span-4 inv-payment-signature' )
						->set_help_text( 'Display signature if it is set in the options page' ),
				)
			);
	}


	/**
	 * Create item repeater fields
	 *
	 * @since    1.0.0
	 */
	private static function fields_items() {
		 Container::make( 'post_meta', __( 'Items list', 'invoiceit' ) )
			->where( 'post_type', '=', 'invoice' )
			->add_fields(
				array(
					Field::make( 'complex', 'inv_items', __( 'Items', 'invoiceit' ) )
					->setup_labels(
						array(
							'plural_name'   => 'Items',
							'singular_name' => 'Item',
						)
					)
					->add_fields(
						array(
							Field::make( 'text', 'inv_item_title', __( 'Title', 'invoiceit' ) )
								->set_classes( 'inv-item-title' ),
							Field::make( 'textarea', 'inv_item_description', __( 'Description', 'invoiceit' ) )
								->set_rows( 2 )
								->set_classes( 'inv-item-description' ),
							Field::make( 'number', 'inv_item_quantity', __( 'Quantity', 'invoiceit' ) )
								->set_min( 0 )
								->set_required( true )
								->set_classes( 'span-item-col inv-item-quantity' ),
							Field::make( 'text', 'inv_item_um', __( 'Unit', 'invoiceit' ) )
								->set_classes( 'span-item-col inv-item-um' ),
							Field::make( 'number', 'inv_item_rate', __( 'Rate', 'invoiceit' ) )
								->set_min( 0 )
								->set_required( true )
								->set_classes( 'span-item-col inv-item-rate' ),
							Field::make( 'number', 'inv_item_discount', __( 'Discount (%)', 'invoiceit' ) )
								->set_min( 0 )
								->set_max( 100 )
								->set_default_value( 0 )
								->set_classes( 'span-item-col inv-item-discount' ),
							Field::make( 'text', 'inv_item_amount', __( 'Amount', 'invoiceit' ) )
								->set_default_value( 0 )
								->set_attribute( 'readOnly', true )
								->set_classes( 'span-item-col inv-item-amount' ),
						)
					)
					->set_header_template(
						'
						<% if (inv_item_title) { %>
							<%- inv_item_title %>
						<% } %>
					'
					)
					->set_classes( 'cf-invoice-items' ),
				)
			);
	}


	/**
	 * Create note fields
	 *
	 * @since    1.0.0
	 */
	private static function fields_note() {
		Container::make( 'post_meta', __( 'Note', 'invoiceit' ) )
			->where( 'post_type', '=', 'invoice' )
			->add_fields(
				array(
					Field::make( 'textarea', 'inv_comment', __( 'Comment', 'invoiceit' ) )
						->set_classes( 'inv-comment' ),
				)
			);
	}
}
