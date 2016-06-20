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
			'wpbw-btn',
			__( 'Bootstrap Button' ),
			array( 'description' => __( 'The button Bootstrap component widget' ) )
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
	}

	/**
	 * The button text field
	 *
	 * @param $instance
	 */
	public function form_field_text( $instance ) {
		$id    = $this->get_field_id( 'text' );
		$name  = $this->get_field_name( 'text' );
		$value = isset( $instance['text'] ) ? $instance['text'] : 'Go to Google!';
		wpbw_field_text($name, 'Text:', compact('id'), $value);
	}

	/**
	 * The button URL field
	 *
	 * @param $instance
	 */
	public function form_field_url( $instance ) {
		$id    = $this->get_field_id( 'url' );
		$name  = $this->get_field_name( 'url' );
		$value = isset( $instance['url'] ) ? $instance['url'] : 'http://google.com';
		wpbw_field_text($name, 'URL:', compact('id'), $value);
	}

	/**
	 * The button type field
	 *
	 * @param $instance
	 */
	public function form_field_type( $instance ) {
		$id    = $this->get_field_id( 'type' );
		$name  = $this->get_field_name( 'type' );
		$value = isset( $instance['type'] ) ? $instance['type'] : 'btn-default';
		$options = array(
			'btn-default' => 'Default (btn-default)',
			'btn-primary' => 'Primary (btn-primary)',
			'btn-success' => 'Success (btn-success)',
			'btn-info'    => 'Info (btn-info)',
			'btn-warning' => 'Warning (btn-warning)',
			'btn-danger'  => 'Danger (btn-danger)',
			'btn-link'    => 'Link (btn-link)',
		);
		wpbw_field_select($name, 'Type:', $options, compact('id'), $value);
	}

	/**
	 * The button size field
	 *
	 * @param $instance
	 */
	public function form_field_size( $instance ) {
		$id    = $this->get_field_id( 'size' );
		$name  = $this->get_field_name( 'size' );
		$value = isset( $instance['size'] ) ? $instance['size'] : '';
		$options = array(
			'' => 'Normal size',
			'btn-lg' => 'Large (btn-lg)',
			'btn-sm' => 'Small (btn-sm)',
			'btn-xs' => 'Extra Small (btn-xs)',
		);
		wpbw_field_select($name, 'Size:', $options, compact('id'), $value);
	}

	/**
	 * The button width field
	 *
	 * @param $instance
	 */
	public function form_field_width( $instance ) {
		$id    = $this->get_field_id( 'width' );
		$name  = $this->get_field_name( 'width' );
		$value = isset( $instance['width'] ) ? $instance['width'] : '';
		$options = array(
			''          => 'Normal width',
			'btn-block' => 'Full width (btn-block)',
		);
		wpbw_field_select($name, 'Width:', $options, compact('id'), $value);
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

		return $instance;
	}
}