<?php

namespace csip\frontend;

use csip\Assets;

// Exit if accessed directly.
defined( 'WPINC' ) || die;

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 */
class Frontend {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Load assets from manifest.json
		$this->assets = new Assets();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( CSIP_NAME . '/css', $this->assets->get( 'styles/main.css' ), array(), CSIP_VERSION, 'all' );
		wp_enqueue_style( CSIP_NAME . '/print', $this->assets->get( 'styles/print.css' ), array(), CSIP_VERSION, 'print' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( CSIP_NAME . '/js', $this->assets->get( 'scripts/main.js' ), array(), CSIP_VERSION, false );
	}

}
