<?php
namespace Arraytics;

class Block {

    public function __construct() {
       // add_action( 'init', array( $this, 'register_block' ) );
        add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
    }

    public function register_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }
    }

    public function enqueue_block_editor_assets() {
        wp_register_script(
            'arraytics-block',
            Arraytics_ASSETS . '/js/index.js',
            [ 'wp-blocks', 'wp-element', 'wp-i18n' ],
            filemtime( Arraytics_PATH . '/assets/js/block.js' ),
            true
        );

        wp_enqueue_script( 'arraytics-block' );
    }
}