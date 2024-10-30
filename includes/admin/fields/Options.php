<?php

namespace csip\admin\fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly.
defined( 'WPINC' ) || die;


/**
 * Class containing fields for the Plugin options page.
 *
 * @since    1.0.0
 */
class Options {


	/**
	 * Load all custom field metaboxes for Plugin Options
	 *
	 * @since    1.0.0
	 */
	public static function load() {
		self::fields_company();
	}

	/**
	 * Create fields for Company details
	 *
	 * @since    1.0.0
	 */
	private static function fields_company() {
		$allowed_tags_info = __( 'The following HTML tags are allowed: ', 'invoiceit' ) . '&lt;b&gt;, &lt;i&gt;';

		Container::make( 'theme_options', __( 'Company Info', 'invoiceit' ) )
			->set_page_menu_title( __( 'Invoice Plugin', 'invoiceit' ) )
			->add_tab(
				__( 'Branding', 'invoiceit' ),
				array(
					Field::make( 'text', 'csip_company_name', __( 'Company Name', 'invoiceit' ) )
						->set_classes( 'csip-company-name' ),
					Field::make( 'text', 'csip_company_web', __( 'Website', 'invoiceit' ) )
						->set_classes( 'csip-company-web' ),
					Field::make( 'image', 'csip_company_logo', __( 'Logo', 'invoiceit' ) )
						->set_help_text( __( 'An image of your company logo for the Invoice header.', 'invoiceit' ) )
						->set_classes( 'span-6 csip-company-logo' )->set_value_type( 'url' ),
					Field::make( 'image', 'csip_company_signature', __( 'Signature', 'invoiceit' ) )
						->set_help_text( __( 'A .png image of your signature if you want to insert it into Invoices.', 'invoiceit' ) )
						->set_classes( 'span-6 csip-company-signature' )
						->set_value_type( 'url' ),
				)
			)
			->add_tab(
				__( 'Address', 'invoiceit' ),
				array(
					Field::make( 'text', 'csip_company_address_1', __( 'Address 1', 'invoiceit' ) )
						->set_classes( 'span-6 csip-company-address-1' ),
					Field::make( 'text', 'csip_company_address_2', __( 'Address 2', 'invoiceit' ) )
						->set_classes( 'span-6 csip-company-address-2' ),
					Field::make( 'text', 'csip_company_city', __( 'City', 'invoiceit' ) )
						->set_classes( 'span-6 csip-company-city' ),
					Field::make( 'text', 'csip_company_zip', __( 'Zip Code', 'invoiceit' ) )
						->set_classes( 'span-6 csip-company-zip' ),
					Field::make( 'select', 'csip_company_country', __( 'Country', 'invoiceit' ) )
						->set_options( \csip\admin\Helpers::get_countries() )
						->set_classes( 'span-6 csip-company-country csip-select2' ),
					Field::make( 'select', 'csip_company_state', __( 'State', 'invoiceit' ) )
						->set_options( \csip\admin\Helpers::get_states() )
						->set_classes( 'span-6 csip-company-state csip-select2' ),
				)
			)
			->add_tab(
				__( 'Contact', 'invoiceit' ),
				array(
					Field::make( 'text', 'csip_company_email', __( 'Email', 'invoiceit' ) )
						->set_attribute( 'pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' )
						->set_classes( 'csip-company-email' ),
					Field::make( 'text', 'csip_company_phone', __( 'Phone number', 'invoiceit' ) )
						->set_classes( 'csip-company-phone' ),
				)
			)
			->add_tab(
				__( 'Legal', 'invoiceit' ),
				array(
					Field::make( 'text', 'csip_company_id', __( 'Company ID', 'invoiceit' ) )
						->set_classes( 'csip-company-id' ),
					Field::make( 'select', 'csip_company_vatreg', __( 'VAT registered', 'invoiceit' ) )
					->set_options(
						array(
							'0' => 'No',
							'1' => 'Yes',
						)
					)
					->set_classes( 'span-6 csip-company-vatreg' ),
					Field::make( 'text', 'csip_company_vatid', __( 'VAT ID', 'invoiceit' ) )
					->set_conditional_logic(
						array(
							array(
								'field' => 'csip_company_vatreg',
								'value' => '1',
							),
						)
					)
					->set_classes( 'span-6 csip-company-vatid' ),
				)
			)
			->add_tab(
				__( 'Invoice Options', 'invoiceit' ),
				array(
					Field::make( 'text', 'csip_company_prefix', __( 'Invoice Prefix', 'invoiceit' ) )
						->set_attribute( 'maxLength', 4 )
						->set_help_text( __( 'If needed you can prefix the invoice number with up to 4 characters for the print version of the invoice.', 'invoiceit' ) )
						->set_classes( 'span-6 csip-company-prefix' ),
					Field::make( 'number', 'csip_company_nin', __( 'Next Invoice Number', 'invoiceit' ) )
						->set_help_text( __( 'This will be the next Invoice number, change this only if you need to reset it.', 'invoiceit' ) )
						->set_default_value( 1 )
						->set_classes( 'span-6 csip-company-nin' ),
					Field::make( 'select', 'csip_company_fallback_currency', __( 'Fallback Currency', 'invoiceit' ) )
						->set_options( \csip\admin\Helpers::get_currencies() )
						->set_classes( 'span-6 csip-company-fallback-currency csip-select2' )
						->set_help_text( __( 'Set a fallback currency if no client is selected for an invoice. If not set it will default to USD.', 'invoiceit' ) ),
					Field::make( 'number', 'csip_company_fallback_tax_rate', __( 'Fallback Tax Rate (%)', 'invoiceit' ) )
						->set_min( 0 )
						->set_default_value( 0 )
						->set_classes( 'span-6 csip-company-fallback-tax-rate' )
						->set_help_text( __( 'Set a fallback tax rate if no client is selected for an invoice.', 'invoiceit' ) ),
					Field::make( 'textarea', 'csip_company_terms', __( 'Terms & Conditions', 'invoiceit' ) )
						->set_classes( 'csip-company-terms' ),
					Field::make( 'textarea', 'csip_company_note', __( 'Note', 'invoiceit' ) )
						->set_classes( 'csip-company-dis' ),
					Field::make( 'text', 'csip_company_footertext', __( 'Footer Text', 'invoiceit' ) )
						->set_classes( 'csip-company-footertext' ),
				)
			);
	}
}
