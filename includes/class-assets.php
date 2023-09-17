<?php
/**
 * Assets
 *
 * @author Rokibul
 * @package Arraytics
 */

namespace Arraytics;

/**
 * Assets Class
 */
class Assets {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_frontend' ) );
	}

	/**
	 * Register Frontend Scripts
	 *
	 * @return void
	 */
	public function register_frontend() {
		wp_register_style( 'arraytics-frontend', ARRAYTICS_ASSETS . '/css/arraytics.css', array(), ARRAYTICS_VERSION );
		wp_register_script( 'arraytics-frontend', ARRAYTICS_ASSETS . '/js/arraytics.js', array( 'jquery' ), ARRAYTICS_VERSION, true );
	}

	/**
	 * Added Frontend Scripts
	 */
	public function enqueue_frontend() {
		wp_enqueue_script( 'arraytics-frontend' );
		wp_enqueue_style( 'arraytics-frontend' );

		wp_localize_script(
			'arraytics-frontend',
			'arraytics_frontend',
			apply_filters(
				'arraytics_frontend_localize_script',
				array(
					'nonce'   => wp_create_nonce( 'arraytics_nonce' ),
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
				),
			)
		);
	}
}
