<?php

namespace Arraytics\Widgets;

class Arraytics_Form_Widget extends \WP_Widget {
    // Constructor
    public function __construct() {
        parent::__construct(
            'arraytics_form_widget',
            'arraytics Form Widget',
            array(
                'description' => 'arraytics widget with a form.',
            )
        );
    }

    public function form($instance) {
        // Widget settings form
        $title = !empty($instance['title']) ? esc_attr($instance['title']) : '';
        $description = !empty($instance['description']) ? esc_attr($instance['description']) : '';
    
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>">Description:</label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo $description; ?></textarea>
        </p>
        <?php
    }

    // Widget display on the front-end
    public function widget($args, $instance) {
        echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo '<div>';
        require_once arraytics()->plugin_path() . '/templates/form.php';
		echo '</div>';
		echo $args['after_widget'];
    }

    // Save widget settings
    public function update($new_instance, $old_instance) {
        $instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description']  = ( ! empty( $new_instance['description'] ) ) ? $new_instance['description'] : '';
		return $instance;
    }
}