<?php
/**
 * Plugin Name: Arraytics Assignement plugin
 * Description: Description
 * Plugin URI: http://#
 * Author: Rokibul
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: arraytics
 * Domain Path: languages
 */

/*
	Copyright (C) Year  Author  Email

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// don't call the file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Arraytics class
 *
 * @class Arraytics The class that holds the entire Arraytics plugin
 */
final class Arraytics {

	/**
	 * GuruX version.
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * Holds various class instances
	 *
	 * @var array
	 */
	private $container = array();

	/**
	 * The single instance of the class.
	 *
	 * @var GuruX
	 */
	private static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_classes();
		register_activation_hook( __FILE__, array( $this, 'activate' ) );

		add_action( 'plugins_loaded', array( $this, 'init_plugin' ), 11 );
	}

	/**
	 * Initializes the Arraytics class
	 *
	 * @return object
	 */
	public static function init() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Magic Method getter to bypass referencing objects
	 *
	 * @param string $prop prop.
	 *
	 * @return object
	 */
	public function __get( $prop ) {
		if ( array_key_exists( $prop, $this->container ) ) {
			return $this->container[ $prop ];
		}
	}

	/**
	 * Check isset properties
	 *
	 * @param string $prop prop.
	 *
	 * @return boolean
	 **/
	public function __isset( $prop ) {
		return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
	}

	/**
	 *  Define Constants
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'ARRAYTICS_VERSION', $this->version );
		define( 'ARRAYTICS_SEPARATOR', ' | ' );
		define( 'ARRAYTICS_FILE', __FILE__ );
		define( 'ARRAYTICS_ROOT', __DIR__ );
		define( 'ARRAYTICS_PATH', dirname( ARRAYTICS_FILE ) );
		define( 'ARRAYTICS_INCLUDES', ARRAYTICS_PATH . '/includes' );
		define( 'ARRAYTICS_URL', plugins_url( '', ARRAYTICS_FILE ) );
		define( 'ARRAYTICS_ASSETS', ARRAYTICS_URL . '/assets' );
	}

	/**
	 * Load the plugin after Woocommerce is loaded
	 *
	 * @return void
	 */
	public function init_plugin() {
		add_action( 'init', array( $this, 'localization_setup' ) );
		add_action( 'widgets_init', array( $this, 'register_custom_form_widget' ) );
	}

	/**
	 * Include all the required files
	 *
	 * @return void
	 */
	public function includes() {
		require_once ARRAYTICS_INCLUDES . '/class-admin.php';
		require_once ARRAYTICS_INCLUDES . '/class-ajax.php';
		require_once ARRAYTICS_INCLUDES . '/class-assets.php';
		require_once ARRAYTICS_INCLUDES . '/class-entry-list.php';
		require_once ARRAYTICS_INCLUDES . '/class-installer.php';
		require_once ARRAYTICS_INCLUDES . '/class-frontend.php';
		require_once ARRAYTICS_INCLUDES . '/class-block.php';
		require_once ARRAYTICS_INCLUDES . '/functions.php';
		require_once ARRAYTICS_INCLUDES . '/widgets/class-form-widget.php';
	}

	/**
	 * Init all the classes
	 *
	 * @return void
	 */
	public function init_classes() {
		new Arraytics\Block();

		if ( is_admin() ) {
			$this->container['admin'] = new Arraytics\Admin();
		}

		$this->container['assets']   = new Arraytics\Assets();
		$this->container['ajax']     = new Arraytics\Ajax();
		$this->container['frontend'] = new Arraytics\Frontend();
	}

	/**
	 * Activation function
	 *
	 * @return void
	 */
	public function activate() {
		$installer = new Arraytics\Installer();
		$installer->create_setup();
	}

	/**
	 * Initialize plugin for localization
	 *
	 * @uses load_plugin_textdomain()
	 */
	public function localization_setup() {
		load_plugin_textdomain( 'arraytics', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Register widget
	 *
	 * @return void
	 */
	public function register_custom_form_widget() {
		register_widget( 'Arraytics\Widgets\Arraytics_Form_Widget' );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
}


/**
 * Load Arraytics Plugin
 *
 * @return GuruX
 */
function arraytics() {
	return Arraytics::init();
}

arraytics();
