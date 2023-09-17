<?php
/**
 * Form Widget
 *
 * @author Rokibul
 * @package Arraytics
 */

namespace Arraytics\Widgets;

/**
 * Form Widget Class
 */
class Arraytics_Form_Widget extends \WP_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			'arraytics_form_widget',
			'arraytics Form Widget',
			array(
				'description' => 'arraytics widget with a form.',
			)
		);
	}

	/**
	 * Widget
	 *
	 * @param array $instance instance.
	 *
	 * @return void
	 */
	public function form( $instance ) {
		$title       = ! empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$description = ! empty( $instance['description'] ) ? esc_attr( $instance['description'] ) : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"> Title: </label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"> Description: </label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $description ); ?></textarea>
		</p>
		<?php
	}

	/**
	 * Widget
	 *
	 * @param array $args args.
	 * @param array $instance instance.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo '<div>';
		require_once arraytics()->plugin_path() . '/templates/form.php';
		echo '</div>';
		echo $args['after_widget'];
	}

	/**
	 * Update
	 *
	 * @param array $new_instance new_instance.
	 * @param array $old_instance old_instance.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? $new_instance['description'] : '';
		return $instance;
	}
}
