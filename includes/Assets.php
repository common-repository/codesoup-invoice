<?php

namespace csip;

// Exit if accessed directly.
defined( 'WPINC' ) || die;
/**
 * Get paths for assets
 *
 * @since      1.0.0
 */
class Assets {

	/**
	 * Manifest file object containing list of all hashed assets
	 *
	 * @var Object
	 * @since    1.0.0
	 */
	private $manifest;


	/**
	 * Absolut path to theme 'dist' folder
	 *
	 * @var string
	 * @since    1.0.0
	 */
	private $dist_path;


	/**
	 * URI to theme 'dist' folder
	 *
	 * @var string
	 * @since    1.0.0
	 */
	private $dist_uri;


	/**
	 * Initiate
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->dist_path     = sprintf( '%sdist', CSIP_PATH );
		$this->dist_uri      = sprintf( '%sdist', CSIP_URI );
		$this->manifest_path = sprintf( '%s/assets.json', $this->dist_path );

		/**
		 * Test for assets.json
		 */
		$this->manifest = file_exists( $this->manifest_path )
			? json_decode( file_get_contents( $this->manifest_path ), true )
			: array();

	}


	/**
	 * Get full URI to single asset
	 *
	 * @param  string $filename File name
	 * @return string           URI to resource
	 * @since    1.0.0
	 */
	public function get( $filename ) {

		return $this->locate( $filename );
	}



	/**
	 * Fix URL for requested files
	 *
	 * @param  string $filename Requested asset
	 * @return [type]           [description]
	 * @since    1.0.0
	 */
	private function locate( $filename ) {

		// Return URL to requested file from manifest.
		if ( array_key_exists( $filename, $this->manifest ) ) {
			return sprintf( '%s/%s', $this->dist_uri, $this->manifest[ $filename ] );
		}

		/**
		 * Return file with non cache blocking
		 */
		return sprintf( '%s/%s', $this->dist_uri, $filename );
	}
}
