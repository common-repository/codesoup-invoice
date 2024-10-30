<?php

namespace csip\admin;

// Exit if accessed directly.
defined( 'WPINC' ) || die;


/**
 * Class contains helper functions for admin.
 *
 * @since      1.0.0
 */
class Helpers {


	/**
	 * Get invoice number for a new invoice
	 *
	 * @return   int
	 * @since    1.0.0
	 */
	public static function get_next_invoice_number() {
		return get_option( '_csip_company_nin' );
	}



	/**
	 * Set the next invoice number
	 *
	 * @return   void
	 * @since    1.0.0
	 */
	public static function set_next_invoice_number() {

		// TODO: check if the invoice already exists with the same invoice prrefix & invoice number.

		$nin = get_option( '_csip_company_nin' ) + 1;
		update_option( '_csip_company_nin', $nin );
	}



	/**
	 * Return a list of clients
	 *
	 * @return   array of clients
	 * @since    1.0.0
	 */
	public static function get_clients() {
		$args = array(

			'post_type' => 'client',
		);

		$qry = new \WP_Query( $args );

		$array = array();
		foreach ( $qry->posts as $client ) {
			$array[ $client->ID ] = $client->post_title;
		}

		asort( $array );
		$clients = array( '0' => __( '-- Select Client', 'invoiceit' ) ) + $array;

		return $clients;
	}



	/**
	 * Return accounts of the company listed in options page
	 *
	 * @return   array of $accounts
	 * @since    1.0.0
	 */
	public static function get_accounts() {

		$args = array(

			'post_type' => 'bankaccount',
		);

		$qry = new \WP_Query( $args );

		$array = array();
		foreach ( $qry->posts as $account ) {
			$array[ $account->ID ] = $account->post_title;
		}

		asort( $array );
		$accounts = array( '0' => __( '-- Select Account', 'invoiceit' ) ) + $array;

		return $accounts;
	}



	/**
	 * Return a list of currencies
	 *
	 * @return   array of currencies
	 * @since    1.0.0
	 */
	public static function get_currencies() {

		$currencies = self::get_currencies_data();

		array_unshift( $currencies, __( '-- Select Currency', 'invoiceit' ) );

		return $currencies;
	}



	/**
	 * Return list of all countries
	 *
	 * @return   array of countries
	 * @since    1.0.0
	 */
	public static function get_countries() {

		$countries = self::get_countries_data();

		$array = array();
		foreach ( $countries as $country ) {
			$array[ $country['alpha3Code'] ] = $country['name'];
		}

		array_unshift( $array, __( '-- Select Country', 'invoiceit' ) );

		return $array;
	}



	/**
	 * Return a list of states of a given country
	 *
	 * @return   array of states
	 * @since    1.0.0
	 */
	public static function get_states() {
		// TODO: fetch states with AJAX.
		$array = array(
			'0' => __( '-- Select State', 'invoiceit' ),
		);

		return $array;
	}



	/**
	 * Return countries data from transients, create transient if does ot exist
	 *
	 * @return   array of countries data
	 * @since    1.0.0
	 */
	private static function get_countries_data() {

		$countries_data = get_transient( 'csip_countries' );

		if ( false === $countries_data ) {

			$countries_json = file_get_contents( 'https://restcountries.eu/rest/v2/all' );
			$countries_data = json_decode( $countries_json, true );

			set_transient( 'csip_countries', $countries_data, 3600 * 24 );
		}

		return $countries_data;

	}



	/**
	 * Return country name from cca3 iso code
	 *
	 * @param    [type] $cca3
	 * @return   string
	 * @since    1.0.0
	 */
	public static function get_country_name( $cca3 ) {

		foreach ( self::get_countries_data() as $country ) {
			if ( $country['alpha3Code'] === $cca3 ) {
				$country_name = $country['name'];
				break;
			}
		}

		return $country_name;

	}



	/**
	 * Return currencies data from transients, create transient if does ot exist
	 *
	 * @return   array of currencies
	 * @since    1.0.0
	 */
	private static function get_currencies_data() {

		$currencies = get_transient( 'csip_currencies' );

		if ( false === $currencies || '' === $currencies ) {

			$countries_data = self::get_countries_data();

			$currencies = array();

			foreach ( $countries_data as $country_data ) {

				foreach ( $country_data['currencies'] as $currency ) {
					$symbol = $currency['symbol']
							? ' (' . $currency['symbol'] . ')'
							: '';

					$currencies[ $currency['code'] ] = $currency['name'] . ' - ' . $currency['code'] . $symbol;
				}
			}

			set_transient( 'csip_currencies', $currencies, 3600 * 24 );

		}

		return $currencies;
	}
}


