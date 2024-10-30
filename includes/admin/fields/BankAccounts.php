<?php

namespace csip\admin\fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly.
defined( 'WPINC' ) || die;


/**
 * Class containing fields for the bank accounts post-type.
 *
 * @since    1.0.0
 */
class BankAccounts {


	/**
	 * Load all custom field metaboxes for Bank Account post-type
	 *
	 * @since    1.0.0
	 */
	public static function load() {
		self::fields_bank_account();
	}


	/**
	 * Create bank account fields
	 *
	 * @since    1.0.0
	 */
	private static function fields_bank_account() {
		$allowed_tags_info = __( 'The following HTML tags are allowed: ', 'invoiceit' ) . '&lt;b&gt;, &lt;i&gt;';

		Container::make( 'post_meta', __( 'Bank Account', 'invoiceit' ) )
			->where( 'post_type', '=', 'bankaccount' )
			->add_fields(
				array(
					Field::make( 'textarea', 'csip_company_account_details', __( 'Account Details', 'invoiceit' ) )
						->set_classes( 'span-6 csip-company-account-details' )
						->set_help_text( $allowed_tags_info )
						->set_rows( 8 ),
					Field::make( 'textarea', 'csip_company_account_details_other', __( 'Other details e.g. Bank Address', 'invoiceit' ) )
						->set_classes( 'span-6 csip-company-account-details-other' )
						->set_help_text( $allowed_tags_info )
						->set_rows( 8 ),
				)
			);
	}

}
