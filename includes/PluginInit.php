<?php

namespace csip;

use csip\Loader;
use csip\I18n;
use csip\admin\Admin;
use csip\admin\Helpers;
use csip\frontend\Frontend;


// Exit if accessed directly.
defined( 'WPINC' ) || die;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 */
class PluginInit {

	/**
	 * The loader that's responsible for maintaining and registering all hooks
	 * that power the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = CSIP_NAME;
		$this->version     = CSIP_VERSION;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$this->loader = new Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_cpt_invoice' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_cpt_client' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_cpt_bank_account' );
		$this->loader->add_action( 'init', $plugin_admin, 'reload_permalink_structure' );
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'boot_custom_fields' );
		$this->loader->add_action( 'carbon_fields_register_fields', $plugin_admin, 'register_custom_fields' );
		$this->loader->add_filter( 'single_template', $plugin_admin, 'get_invoice_template' );
		$this->loader->add_action( 'transition_post_status', $plugin_admin, 'on_transition_invoice', 10, 3 );

		/**
		 * Add invoice number to Invoice CPT table
		 */
		$this->loader->add_filter( 'manage_invoice_posts_columns', $plugin_admin, 'show_invoice_number_column' );
		$this->loader->add_filter( 'manage_edit-invoice_sortable_columns', $plugin_admin, 'sortable_invoice_number_column' );
		$this->loader->add_action( 'manage_invoice_posts_custom_column', $plugin_admin, 'fill_invoice_number_column', 10, 2 );

		/**
		 * Add invoice client to Invoice CPT table
		 */
		$this->loader->add_filter( 'manage_invoice_posts_columns', $plugin_admin, 'show_invoice_client_column' );
		$this->loader->add_filter( 'manage_edit-invoice_sortable_columns', $plugin_admin, 'sortable_invoice_client_column' );
		$this->loader->add_action( 'manage_invoice_posts_custom_column', $plugin_admin, 'fill_invoice_client_column', 10, 2 );

		/**
		 * Use AJAX to fetch clients NET
		 */
		$this->loader->add_action( 'wp_ajax_do_fetch_client_net', $plugin_admin, 'fetch_client_net' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Frontend( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
