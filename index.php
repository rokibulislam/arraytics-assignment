<?php
/**
 * Plugin Name: Arraytics Assignement plugin
 * Description: Description
 * Plugin URI: http://#
 * Author: Author
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: text-domain
 * Domain Path: domain/path
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

// don't call the file directly

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Arraytics class
 *
 * @class Arraytics The class that holds the entire Arraytics plugin
 *
 */
final Class Arraytics {
    
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
    private $container = [];

    /**
     * The single instance of the class.
     *
     * @var GuruX
     */
    private static $instance = null;

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->define_constants();
        $this->includes();
		$this->init_classes();
		register_activation_hook( __FILE__, array( $this, 'activate' ) );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ], 11 );
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
     * @return void
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
		define( 'Arraytics_VERSION', $this->version );
		define( 'Arraytics_SEPARATOR', ' | ' );
		define( 'Arraytics_FILE', __FILE__ );
		define( 'Arraytics_ROOT', __DIR__ );
		define( 'Arraytics_PATH', dirname( Arraytics_FILE ) );
		define( 'Arraytics_INCLUDES', Arraytics_PATH . '/includes' );
		define( 'Arraytics_URL', plugins_url( '', Arraytics_FILE ) );
		define( 'Arraytics_ASSETS', Arraytics_URL . '/assets' );
	}

    /**
     * Load the plugin after Woocommerce is loaded
     *
     * @return void
     */
    public function init_plugin() {
        add_action( 'init', [ $this, 'localization_setup' ] );        
        add_action( 'widgets_init', [ $this, 'register_custom_form_widget' ] );
    }

    /**
	 * Include all the required files
	 *
	 * @return void
	 */
	public function includes() {
        require_once Arraytics_INCLUDES . '/class-admin.php';
        require_once Arraytics_INCLUDES . '/class-ajax.php';
        require_once Arraytics_INCLUDES . '/class-assets.php';
        require_once Arraytics_INCLUDES . '/class-entry-list.php';
        require_once Arraytics_INCLUDES . '/class-installer.php';
        require_once Arraytics_INCLUDES . '/class-frontend.php';
        require_once Arraytics_INCLUDES . '/class-block.php';
        require_once Arraytics_INCLUDES . '/functions.php';
        require_once Arraytics_INCLUDES . '/widgets/class-form-widget.php';
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

		$this->container['assets']    = new Arraytics\Assets();
		$this->container['ajax']      = new Arraytics\Ajax();
		$this->container['frontend']  = new Arraytics\Frontend();
		// $this->container['block']     = 
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