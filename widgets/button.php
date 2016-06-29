<?php

/**
 * The .btn Bootstrap component as WordPress widget
 *
 * @author Junior Grossi <@jgrossi>
 */
class WPBW_Widget_Button extends WP_Widget {
	/**
	 * The constructor
	 */
	public function __construct() {
		parent::__construct(
			'wpbw-button',
			__( 'Button' ),
			array(
				'description'   => __( 'Set a link apart by styling it like a button.' ),
				'panels_groups' => array( 'wp-bootstrap-widgets' ),
				'panels_icon'   => 'dashicons dashicons-slides',
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
		$classes .= ' ' . $instance['size'];
		$classes .= ' ' . $instance['width'];
		if ( isset( $instance['class'] ) ) {
			$classes .= ' ' . $instance['class'];
		}
		echo $args['before_widget'];
		?>
		<a href="<?php echo $instance['url']; ?>" class="btn <?php echo $classes; ?>">
			<?php echo $instance['text']; ?>
		</a>
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
		$this->form_field_url( $instance );
		$this->form_field_type( $instance );
		$this->form_field_size( $instance );
		$this->form_field_width( $instance );
		$this->form_field_class( $instance );
	}

	/**
	 * The button text field
	 *
	 * @param $instance
	 */
	public function form_field_text( $instance ) {
		$id    = $this->get_field_id( 'text' );
		$name  = $this->get_field_name( 'text' );
		$value = isset( $instance['text'] ) ? $instance['text'] : get_option('blogname');
		wpbw_field_text( $name, 'Button Text:', compact( 'id' ), $value );
	}

	/**
	 * The button URL field
	 *
	 * @param $instance
	 */
	public function form_field_url( $instance ) {
		$id    = $this->get_field_id( 'url' );
		$name  = $this->get_field_name( 'url' );
		$value = isset( $instance['url'] ) ? $instance['url'] : home_url();
		wpbw_field_text( $name, 'Link URL:', compact( 'id' ), $value );
	}

	/**
	 * The button type field
	 *
	 * @param $instance
	 */
	public function form_field_type( $instance ) {
		$id      = $this->get_field_id( 'type' );
		$name    = $this->get_field_name( 'type' );
		$value   = isset( $instance['type'] ) ? $instance['type'] : 'btn-default';
		$options = array(
			'btn-default' => 'Default',
			'btn-primary' => 'Primary',
			'btn-success' => 'Success',
			'btn-info'    => 'Info',
			'btn-warning' => 'Warning',
			'btn-danger'  => 'Danger',
			'btn-link'    => 'Link',
		);
		wpbw_field_select( $name, 'Style:', $options, compact( 'id' ), $value );
	}

	/**
	 * The button size field
	 *
	 * @param $instance
	 */
	public function form_field_size( $instance ) {
		$id      = $this->get_field_id( 'size' );
		$name    = $this->get_field_name( 'size' );
		$value   = isset( $instance['size'] ) ? $instance['size'] : '';
		$options = array(
			''       => 'Normal',
			'btn-lg' => 'Large',
			'btn-sm' => 'Small',
			'btn-xs' => 'Extra Small',
		);
		wpbw_field_select( $name, 'Size:', $options, compact( 'id' ), $value );
	}

	/**
	 * The button width field
	 *
	 * @param $instance
	 */
	public function form_field_width( $instance ) {
		$id      = $this->get_field_id( 'width' );
		$name    = $this->get_field_name( 'width' );
		$value   = isset( $instance['width'] ) ? $instance['width'] : '';
		$options = array(
			''          => 'Content Width (as wide as text)',
			'btn-block' => 'Container Width (as wide as whatever the button is inside of)',
		);
		wpbw_field_select( $name, 'Width:', $options, compact( 'id' ), $value );
	}

	/**
	 * Additional classes for button widget
	 *
	 * @param $instance
	 */
	public function form_field_class( $instance ) {
		$id    = $this->get_field_id( 'class' );
		$name  = $this->get_field_name( 'class' );
		$value = isset( $instance['class'] ) ? $instance['class'] : '';
		wpbw_field_text( $name, 'Additional CSS Classes:', compact( 'id' ), $value );
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
		$instance          = array();
		$instance['url']   = strip_tags( $new_instance['url'] );
		$instance['type']  = strip_tags( $new_instance['type'] );
		$instance['text']  = strip_tags( $new_instance['text'] );
		$instance['size']  = strip_tags( $new_instance['size'] );
		$instance['width'] = strip_tags( $new_instance['width'] );
		$instance['class'] = strip_tags( $new_instance['class'] );

		return $instance;
	}
}