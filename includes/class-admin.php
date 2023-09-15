<?php 
namespace Arraytics;

/**
 * Admin Class
 * 
 */
class Admin {

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    public function admin_menu() {
        global $submenu;

        $capability = 'manage_options';
        $slug       = 'arraytics';

        $hook = add_menu_page( __( 'Arraytics Report App', 'arraytics' ), __( 'Arraytics Report App', 'arraytics' ), $capability, $slug, [ $this, 'entries_page' ], 'dashicons-text' );         
    }

    public function entries_page() {
        require_once Arraytics_INCLUDES . '/html/form-list-view.php';
    }
}