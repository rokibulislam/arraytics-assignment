<?php
/**
 * Block
 *
 * @author Rokibul
 * @package Arraytics
 */

namespace Arraytics;

/**
 * Block Class
 */
class Block {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
	}

	/**
	 * Add Block Assets
	 *
	 * @return void
	 */
	public function enqueue_block_editor_assets() {
		wp_register_script(
			'arraytics-block',
			ARRAYTICS_ASSETS . '/js/index.js',
			array( 'wp-blocks', 'wp-element', 'wp-i18n' ),
			filemtime( ARRAYTICS_PATH . '/assets/js/block.js' ),
			true
		);

		wp_enqueue_script( 'arraytics-block' );
	}
}
