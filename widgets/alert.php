<?php

/**
 * The image Bootstrap component as WordPress widget
 *
 * @author Junior Grossi <@jgrossi>
 */
class WPBW_Widget_Alert extends WP_Widget {

	/**
	 * The image component constructor
	 */
	public function __construct() {
		parent::__construct(
			'wpbw-alert',
			__( 'Bootstrap Alert' ),
			array(
				'description'   => __( 'The .alert Bootstrap component widget' ),
				'panels_groups' => array( 'wp-bootstrap-widgets' ),
				'panels_icon'   => 'dashicons dashicons-format-chat',
			)
		);
	}

	/**
	 * The widget output
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$classes = $instance['type'];
		$classes .= ' ' . $instance['dismiss'];
		$text = $instance['text'];
		echo $args['before_widget'];
		?>
		<div class="alert <?php echo $classes; ?>">
			<?php echo $text; ?>
		</div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Widget configuration fields
	 *
	 * @param array $instance
	 *
	 * @return void
	 */
	public function form( $instance ) {
		$this->form_field_text( $instance );
		$this->form_field_type( $instance );
		$this->form_field_dismiss( $instance );
	}

	/**
	 * The alert text content
	 *
	 * @param $instance
	 */
	public function form_field_text( $instance ) {
		$id         = $this->get_field_id( 'text' );
		$name       = $this->get_field_name( 'text' );
		$attributes = array( 'id' => $id, 'rows' => 4 );
		$value      = isset( $instance['text'] ) ? $instance['text'] : 'My text here';
		wpbw_field_textarea( $name, __( 'Text content:' ), $attributes, $value );
	}

	/**
	 * The alert type class
	 *
	 * @param $instance
	 */
	public function form_field_type( $instance ) {
		$id      = $this->get_field_id( 'type' );
		$name    = $this->get_field_name( 'type' );
		$value   = isset( $instance['type'] ) ? $instance['type'] : '';
		$options = array(
			'alert-success' => 'Success message',
			'alert-info'    => 'Info message',
			'alert-warning' => 'Warning message',
			'alert-danger'  => 'Danger message',
		);
		wpbw_field_select( $name, __( 'Type:' ), $options, compact( 'id' ), $value );
	}

	/**
	 * The alert dismissible class
	 *
	 * @param $instance
	 */
	public function form_field_dismiss( $instance ) {
		$id      = $this->get_field_id( 'dismiss' );
		$name    = $this->get_field_name( 'dismiss' );
		$value   = isset( $instance['dismiss'] ) ? $instance['dismiss'] : '';
		$options = array(
			''                  => 'Do not dismiss',
			'alert-dismissible' => 'Make it dismissible',
		);
		wpbw_field_select( $name, __( 'Dismissible:' ), $options, compact( 'id' ), $value );
	}

	/**
	 * Save the widget options
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance            = array();
		$instance['text']    = strip_tags( $new_instance['text'] );
		$instance['type']    = strip_tags( $new_instance['type'] );
		$instance['dismiss'] = strip_tags( $new_instance['dismiss'] );

		return $instance;
	}
}