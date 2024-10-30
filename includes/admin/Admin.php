<?php

namespace csip\admin;

use csip\Assets;
use csip\admin\Helpers;

// Exit if accessed directly.
defined( 'WPINC' ) || die;


/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 */
class Admin {


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		// Load assets from manifest.json.
		$this->assets = new Assets();
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( CSIP_NAME . '/wp/css', $this->assets->get( 'styles/admin.css' ), array(), CSIP_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( CSIP_NAME . '/wp/js', $this->assets->get( 'scripts/admin.js' ), array( 'jquery' ), CSIP_VERSION, true );

		/**
		 * CHeck if it is a new or existing invoice post-type and load the js if so
		 */
		global $pagenow;
		if (
				(
				'post.php' === $pagenow
				&& isset( $_GET['post'] )
				&& 'invoice' === get_post_type( $_GET['post'] )
				)
			||
				(
				'post-new.php' === $pagenow
				&& isset( $_GET['post_type'] )
				&& 'invoice' === $_GET['post_type']
				)
			) {
			wp_enqueue_script( CSIP_NAME . '/wp/invoice', $this->assets->get( 'scripts/invoice.js' ), array(), CSIP_VERSION, false );
			wp_enqueue_script( CSIP_NAME . 'wp/aj', $this->assets->get( 'scripts/ajax.js' ), array( 'jquery' ), CSIP_VERSION, true );
		}

		/**
		 * Enquee AJAX scripts
		 */
		wp_localize_script(
			CSIP_NAME . 'wp/aj',
			'csip',
			array(
				'nonce'    => wp_create_nonce( 'csip' ),
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			)
		);

	}


	/**
	 * Register custom post-type Invoice
	 *
	 * @since    1.0.0
	 */
	public function register_cpt_invoice() {

		$labels = array(
			'name'                  => _x( 'Invoices', 'Post type general name', 'invoiceit' ),
			'singular_name'         => _x( 'Invoice', 'Post type singular name', 'invoiceit' ),
			'menu_name'             => _x( 'Invoices', 'Admin Menu text', 'invoiceit' ),
			'name_admin_bar'        => _x( 'Invoice', 'Add New on Toolbar', 'invoiceit' ),
			'add_new'               => __( 'Add New', 'invoiceit' ),
			'add_new_item'          => __( 'Add New Invoice', 'invoiceit' ),
			'new_item'              => __( 'New Invoice', 'invoiceit' ),
			'edit_item'             => __( 'Edit Invoice', 'invoiceit' ),
			'view_item'             => __( 'View Invoice', 'invoiceit' ),
			'all_items'             => __( 'All Invoices', 'invoiceit' ),
			'search_items'          => __( 'Search Invoices', 'invoiceit' ),
			'parent_item_colon'     => __( 'Parent Invoices:', 'invoiceit' ),
			'not_found'             => __( 'No invoices found.', 'invoiceit' ),
			'not_found_in_trash'    => __( 'No invoices found in Trash.', 'invoiceit' ),
			'archives'              => _x( 'Invoice archives', 'The post type archive label used in nav menus. Default “Post Archives”.', 'invoiceit' ),
			'insert_into_item'      => _x( 'Insert into invoice', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post).', 'invoiceit' ),
			'filter_items_list'     => _x( 'Filter invoice list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”.', 'invoiceit' ),
			'items_list_navigation' => _x( 'Invoices list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”.', 'invoiceit' ),
			'items_list'            => _x( 'Invoices list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”.', 'invoiceit' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_in_nav_menus'  => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'invoice' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
			'menu_icon'          => 'dashicons-media-spreadsheet',
		);

		register_post_type( 'invoice', $args );

	}


	/**
	 * Register custom post-type Client
	 *
	 * @since    1.0.0
	 */
	public function register_cpt_client() {

		$labels = array(
			'name'                  => _x( 'Clients', 'Post type general name', 'invoiceit' ),
			'singular_name'         => _x( 'Client', 'Post type singular name', 'invoiceit' ),
			'menu_name'             => _x( 'Clients', 'Admin Menu text', 'invoiceit' ),
			'name_admin_bar'        => _x( 'Client', 'Add New on Toolbar', 'invoiceit' ),
			'add_new'               => __( 'Add New', 'invoiceit' ),
			'add_new_item'          => __( 'Add New Client', 'invoiceit' ),
			'new_item'              => __( 'New Client', 'invoiceit' ),
			'edit_item'             => __( 'Edit Client', 'invoiceit' ),
			'view_item'             => __( 'View Client', 'invoiceit' ),
			'all_items'             => __( 'All Clients', 'invoiceit' ),
			'search_items'          => __( 'Search Clients', 'invoiceit' ),
			'parent_item_colon'     => __( 'Parent Clients:', 'invoiceit' ),
			'not_found'             => __( 'No clients found.', 'invoiceit' ),
			'not_found_in_trash'    => __( 'No clients found in Trash.', 'invoiceit' ),
			'archives'              => _x( 'Client archives', 'The post type archive label used in nav menus. Default “Post Archives”.', 'invoiceit' ),
			'insert_into_item'      => _x( 'Insert into client', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post).', 'invoiceit' ),
			'filter_items_list'     => _x( 'Filter client list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”.', 'invoiceit' ),
			'items_list_navigation' => _x( 'Clients list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”.', 'invoiceit' ),
			'items_list'            => _x( 'Clients list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”.', 'invoiceit' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_in_nav_menus'  => false,
			'rewrite'            => array( 'slug' => 'client' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
			'menu_icon'          => 'dashicons-groups',
		);

		register_post_type( 'client', $args );

	}


	/**
	 * Register custom post-type Bank Account
	 *
	 * @since    1.0.0
	 */
	public function register_cpt_bank_account() {

		$labels = array(
			'name'                  => _x( 'Bank Accounts', 'Post type general name', 'invoiceit' ),
			'singular_name'         => _x( 'Bank Account', 'Post type singular name', 'invoiceit' ),
			'menu_name'             => _x( 'Bank Accounts', 'Admin Menu text', 'invoiceit' ),
			'name_admin_bar'        => _x( 'Bank Account', 'Add New on Toolbar', 'invoiceit' ),
			'add_new'               => __( 'Add New', 'invoiceit' ),
			'add_new_item'          => __( 'Add New Bank Account', 'invoiceit' ),
			'new_item'              => __( 'New Bank Account', 'invoiceit' ),
			'edit_item'             => __( 'Edit Bank Account', 'invoiceit' ),
			'view_item'             => __( 'View Bank Account', 'invoiceit' ),
			'all_items'             => __( 'All Bank Accounts', 'invoiceit' ),
			'search_items'          => __( 'Search Bank Accounts', 'invoiceit' ),
			'parent_item_colon'     => __( 'Parent Bank Accounts:', 'invoiceit' ),
			'not_found'             => __( 'No bank accounts found.', 'invoiceit' ),
			'not_found_in_trash'    => __( 'No bank accounts found in Trash.', 'invoiceit' ),
			'archives'              => _x( 'Bank Account archives', 'The post type archive label used in nav menus. Default “Post Archives”.', 'invoiceit' ),
			'insert_into_item'      => _x( 'Insert into bank account', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post).', 'invoiceit' ),
			'filter_items_list'     => _x( 'Filter bank account list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”.', 'invoiceit' ),
			'items_list_navigation' => _x( 'Bank Accounts list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”.', 'invoiceit' ),
			'items_list'            => _x( 'Bank Accounts list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”.', 'invoiceit' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_in_nav_menus'  => false,
			'rewrite'            => array( 'slug' => 'bankaccount' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
			'menu_icon'          => 'dashicons-bank',
		);

		register_post_type( 'bankaccount', $args );

	}


	/**
	 * Boot Carbon Fields with default IoC dependencies
	 *
	 * @since    1.0.0
	 */
	public function boot_custom_fields() {

		\Carbon_Fields\Carbon_Fields::boot();
	}


	/**
	 * Load fields of custom post-types for Carbon Fields
	 *
	 * @since    1.0.0
	 */
	public function register_custom_fields() {

		fields\Options::load();
		fields\Clients::load();
		fields\Invoice::load();
		fields\BankAccounts::load();
	}


	/**
	 * Register custom invoice post type template
	 *
	 * @param    [type] $single_template
	 * @return   void
	 * @since    1.0.0
	 */
	public function get_invoice_template( $single_template ) {
		global $post;
		if ( 'invoice' === $post->post_type ) {
			$single_template = trailingslashit( CSIP_PATH ) . 'includes/templates/invoice.php';
		}

		return $single_template;
	}


	/**
	 * Handle next invoice number only if new Invoice is manually published or saved as draft
	 *
	 * @param [type] $new_status
	 * @param [type] $old_status
	 * @param [type] $post
	 * @return void
	 */
	public function on_transition_invoice( $new_status, $old_status, $post ) {

		$allowed_new_status = array( 'publish', 'draft' );
		$inv_number         = get_post_meta( $post->ID, '_inv_number', true );

		if (
		$new_status === $old_status
		|| ( 'auto-draft' === $old_status && 'draft' === $new_status )
		|| ! in_array( $new_status, $allowed_new_status, true )
		|| ! empty( $inv_number )
		) {
			return;
		}

		Helpers::set_next_invoice_number();

	}


	/**
	 * Add column with invoice number to Invoice CPT
	 *
	 * @param    [type] $columns
	 * @return   void
	 * @since    1.0.0
	 */
	public function show_invoice_number_column( $columns ) {
		$columns = array_merge( $columns, array( 'invoice_number' => __( 'Invoice Number', 'invoiceit' ) ) );

		// Move the Date column to the end.
		$reposition = $columns['date'];
		unset( $columns['date'] );
		$columns['date'] = $reposition;

		return $columns;
	}


	/**
	 * Make the invoice number column soratblle
	 *
	 * @param    [type] $columns
	 * @return   void
	 * @since    1.0.0
	 */
	public function sortable_invoice_number_column( $columns ) {
		$columns['invoice_number'] = 'invoice_number';
		return $columns;
	}


	/**
	 * Fill invoice_number column with data
	 *
	 * @param    [type] $column_key
	 * @param    [type] $post_id
	 * @return   void
	 * @since    1.0.0
	 */
	public function fill_invoice_number_column( $column_key, $post_id ) {
		if ( $column_key == 'invoice_number' ) {
			$invoice_number = get_post_meta( $post_id, '_inv_number', true );
			if ( $invoice_number ) {
				echo '<span>' . $invoice_number . '</span>';
			} else {
				echo '<span>-</span>';
			}
		}
	}


	/**
	 * Add column with invoice client to Invoice CPT
	 *
	 * @param    [type] $columns
	 * @return   void
	 * @since    1.0.0
	 */
	public function show_invoice_client_column( $columns ) {
		$columns = array_merge( $columns, array( 'invoice_client' => __( 'Client', 'invoiceit' ) ) );

		// Move the Date column to the end.
		$reposition = $columns['date'];
		unset( $columns['date'] );
		$columns['date'] = $reposition;

		return $columns;
	}


	/**
	 * Make the invoice client column soratblle
	 *
	 * @param    [type] $columns
	 * @return   void
	 * @since    1.0.0
	 */
	public function sortable_invoice_client_column( $columns ) {
		$columns['invoice_client'] = 'invoice_client';
		return $columns;
	}


	/**
	 * Fill invoice_client column with data
	 *
	 * @param    [type] $column_key
	 * @param    [type] $post_id
	 * @return   void
	 * @since    1.0.0
	 */
	public function fill_invoice_client_column( $column_key, $post_id ) {
		if ( $column_key == 'invoice_client' ) {
			$invoice_client = get_post_meta( $post_id, '_inv_client', true );
			if ( $invoice_client ) {
				echo '<span>' . get_the_title( $invoice_client ) . '</span>';
			} else {
				echo '<span>-</span>';
			}
		}
	}


	/**
	 * Reloads permalink structure for new post-types
	 *
	 * @return void
	 */
	public function reload_permalink_structure() {

		if ( ! get_option( 'csip_permalinks_flushed' ) ) {
			error_log( 'flushing rules' );
			flush_rewrite_rules( false );
			update_option( 'csip_permalinks_flushed', 1 );

		}

	}


	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function fetch_client_net() {

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'csip' ) ) {
			die( 'Permission denied' );
		}

		/**
		 * Default response
		 */
		$response = array(
			'status'    => 500,
			'message'   => 'Something is wrong, please try again later ...',
			'client_id' => false,
		);

		$client_id = intval( $_POST['params']['client_id'] );

		$net = get_post_meta( $client_id, '_cli_net_period', true );

		if ( $net ) {
			$response['status']  = 200;
			$response['message'] = 'success';
			$response['net']     = $net;
		}

		die( json_encode( $response ) );
	}

}
