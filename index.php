<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://www.codesoup.co
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       InvoiceIT
 * Plugin URI:        https://github.com/code-soup/invoice-plugin
 * Description:       WordPress Plugin for invoicing with client managment
 * Version:           1.0.1
 * Author:            Code Soup
 * Author URI:        https://github.com/code-soup/invoice-plugin
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       invoiceit
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
defined( 'WPINC' ) || die;


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/Activator.php
 */
register_activation_hook(
	__FILE__,
	function() {

		// On activate do this.
		csip\Activator::activate();
	}
);


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/Deactivator.php
 */
register_deactivation_hook(
	__FILE__,
	function() {

		// On activate do this.
		csip\Deactivator::deactivate();
	}
);


// Run the plugin.
require 'run.php';
