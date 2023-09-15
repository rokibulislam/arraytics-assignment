<?php 

namespace Arraytics;

class Frontend {

    public function __construct() {
        add_shortcode( 'arraytics-form', [ $this, 'render_form' ] );
        add_shortcode( 'arraytics-report', [ $this, 'render_report' ] );
    }

    public function render_form( $atts ) {
        ob_start();
        
        arraytics()->assets->enqueue_frontend();

        require_once arraytics()->plugin_path() . '/templates/form.php';
        return ob_get_clean();
    }

    public function render_report( $atts ) {
		$entries = arraytics_get_entries();
        ob_start();
        arraytics()->assets->enqueue_frontend();
        require_once arraytics()->plugin_path() . '/templates/report.php';
        return ob_get_clean();
    }
}