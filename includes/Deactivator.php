<?php

namespace csip;

// Exit if accessed directly.
defined( 'WPINC' ) || die;


/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 */
class Deactivator {

	/**
	 * On deactivation
	 *
	 * @return void
	 */
	public static function deactivate() {
		flush_rewrite_rules( false );
	}

}
