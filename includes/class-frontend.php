<?php
/**
 * Frontend
 *
 * @author Rokibul
 * @package Arraytics
 */

namespace Arraytics;

/**
 * Frontend Class
 */
class Frontend {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_shortcode( 'arraytics-form', array( $this, 'render_form' ) );
		add_shortcode( 'arraytics-report', array( $this, 'render_report' ) );
	}

	/**
	 * Render Form
	 *
	 * @param array $atts atts.
	 *
	 * @return string
	 */
	public function render_form( $atts ) {
		ob_start();
		arraytics()->assets->enqueue_frontend();
		require_once arraytics()->plugin_path() . '/templates/form.php';
		return ob_get_clean();
	}

	/**
	 * Render Report
	 *
	 * @param array $atts atts.
	 *
	 * @return string
	 */
	public function render_report( $atts ) {
		$entries = arraytics_get_entries();
		ob_start();
		$user = wp_get_current_user();

		if ( current_user_can( 'edit_posts' ) ) {
			arraytics()->assets->enqueue_frontend();
			require_once arraytics()->plugin_path() . '/templates/report.php';
		} else {
			echo 'user not allowed';
		}

		return ob_get_clean();
	}
}
