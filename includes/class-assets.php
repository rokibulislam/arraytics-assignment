<?php
namespace Arraytics;

/**
 * Assets Class
 * 
 */
class Assets {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_frontend' ] );
        add_action('admin_enqueue_scripts', [ $this, 'enqueue_datepicker' ] );
    }

    function enqueue_datepicker() {
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style('jquery-ui-datepicker-style', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    }

    public function register_frontend() {
        wp_register_style( 'arraytics-frontend', Arraytics_ASSETS . '/css/arraytics.css', [], Arraytics_VERSION );
        wp_register_script( 'arraytics-frontend', Arraytics_ASSETS . '/js/arraytics.js', ['jquery'], Arraytics_VERSION, true );
    }

    public function enqueue_frontend() {
        wp_enqueue_script( 'arraytics-frontend' );
        wp_enqueue_style( 'arraytics-frontend' );

        wp_localize_script(
            'arraytics-frontend', 
            'arraytics_frontend', 
            apply_filters(
                'arraytics_frontend_localize_script',
                array(
                    'nonce'      => wp_create_nonce( 'arraytics_nonce' ),
                    'ajaxurl'    => admin_url( 'admin-ajax.php' ),
                )
            )
        );
    }
}