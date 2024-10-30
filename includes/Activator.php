<?php

namespace csip;

// Exit if accessed directly.
defined( 'WPINC' ) || die;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 */
class Activator {

	/**
	 * On activation
	 *
	 * @return void
	 */
	public static function activate() {
		update_option( 'csip_permalinks_flushed', 0 );

		/**
		 * Set the first invoice number to 1
		 */
		if ( ! get_option( 'csip_company_nin' ) ) {
			update_option( 'csip_company_nin', 1 );
		}
	}

}
