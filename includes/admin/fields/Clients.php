<?php

namespace csip\admin\fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly.
defined( 'WPINC' ) || die;


/**
 * Class containing fields for the Client post-type.
 *
 * @since    1.0.0
 */
class Clients {


	/**
	 * Load all custom field metaboxes for Client post-type
	 *
	 * @since    1.0.0
	 */
	public static function load() {
		self::fields_address();
		self::fields_contact();
		self::fields_other();
		self::fields_note();
	}


	/**
	 * Create address fields
	 *
	 * @since    1.0.0
	 */
	private static function fields_address() {
		Container::make( 'post_meta', __( 'Address', 'invoiceit' ) )
			->where( 'post_type', '=', 'client' )
			->add_fields(
				array(
					Field::make( 'text', 'cli_address_1', __( 'Address 1', 'invoiceit' ) )
						->set_classes( 'span-4 cli-address-1' ),
					Field::make( 'text', 'cli_address_2', __( 'Address 2', 'invoiceit' ) )
						->set_classes( 'span-4 cli-address-2' ),
					Field::make( 'text', 'cli_city', __( 'City', 'invoiceit' ) )
						->set_classes( 'span-4 cli-city' ),
					Field::make( 'text', 'cli_zip', __( 'Zip Code', 'invoiceit' ) )
						->set_classes( 'span-4 cli-zip' ),
					Field::make( 'select', 'cli_country', __( 'Country', 'invoiceit' ) )
						->set_options( \csip\admin\Helpers::get_countries() )
						->set_classes( 'span-4 cli-country csip-select2' ),
					Field::make( 'select', 'cli_state', _x( 'State', 'As a State of a Country', 'invoiceit' ) )
						->set_options( \csip\admin\Helpers::get_states() )
						->set_classes( 'span-4 cli-state csip-select2' ),
				)
			);
	}


	/**
	 * Create contact fields
	 *
	 * @since    1.0.0
	 */
	public static function fields_contact() {
		Container::make( 'post_meta', __( 'Contact Details', 'invoiceit' ) )
			->where( 'post_type', '=', 'client' )
			->add_fields(
				array(
					Field::make( 'text', 'cli_name', __( 'Name', 'invoiceit' ) )
						->set_classes( 'span-6 cli-name' ),
					Field::make( 'text', 'cli_email', __( 'Email', 'invoiceit' ) )
						->set_attribute( 'pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' )
						->set_classes( 'span-6 cli-email' ),
					Field::make( 'text', 'cli_phone', __( 'Phone number', 'invoiceit' ) )
						->set_classes( 'span-6 cli-phone' ),
					Field::make( 'text', 'cli_mobile', __( 'Mobile number', 'invoiceit' ) )
						->set_classes( 'span-6 cli-mobile' ),
					Field::make( 'complex', 'cli_contacts', __( 'Other Contacts', 'invoiceit' ) )
					->setup_labels(
						array(
							'plural_name'   => 'Contacts',
							'singular_name' => 'Contact',
						)
					)
					->set_layout( 'tabbed-vertical' )
					->add_fields(
						array(
							Field::make( 'text', 'cli_contact_name', __( 'Name', 'invoiceit' ) )
								->set_classes( 'span-4 cli-contact-name' ),
							Field::make( 'text', 'cli_contact_email', __( 'Email', 'invoiceit' ) )
								->set_attribute( 'pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' )
								->set_classes( 'span-4 cli-contact-email' ),
							Field::make( 'text', 'cli_contact_mobile', __( 'Mobile number', 'invoiceit' ) )
								->set_classes( 'span-4 cli-contact-mobile' ),
						)
					)
					->set_header_template(
						'
						<% if (cli_contact_name) { %>
							<%- cli_contact_name %>
						<% } %>
					'
					),
				)
			);
	}


	/**
	 * Create other details fields
	 *
	 * @since    1.0.0
	 */
	public static function fields_other() {
		Container::make( 'post_meta', __( 'Other Details', 'invoiceit' ) )
			->where( 'post_type', '=', 'client' )
			->add_fields(
				array(
					Field::make( 'number', 'cli_tax_rate', __( 'Tax Rate (%)', 'invoiceit' ) )
						->set_min( 0 )
						->set_default_value( 0 )
						->set_classes( 'span-6 cli-tax-rate' ),
					Field::make( 'number', 'cli_net_period', _x( 'Net', 'The period of time between an invoice is issued and the date payment is due', 'invoiceit' ) )
						->set_min( 0 )
						->set_default_value( 30 )
						->set_classes( 'span-6 cli-net_period' )
						->set_help_text( 'Days until the payment is due' ),
					Field::make( 'text', 'cli_vatid', __( 'VAT ID', 'invoiceit' ) )
						->set_classes( 'span-6 cli-vatid' ),
					Field::make( 'select', 'cli_currency', __( 'Currency', 'invoiceit' ) )
						->set_options( \csip\admin\Helpers::get_currencies() )
						->set_classes( 'span-6 cli-currency csip-select2' ),
				)
			);
	}


	/**
	 * Create note fields
	 *
	 * @since    1.0.0
	 */
	public static function fields_note() {
		Container::make( 'post_meta', __( 'Note', 'invoiceit' ) )
			->where( 'post_type', '=', 'client' )
			->add_fields(
				array(
					Field::make( 'textarea', 'cli_comment', __( 'Comment', 'invoiceit' ) )
						->set_classes( 'cli-comment' ),
				)
			);
	}
}
