<?php

/**
 * The "well" Bootstrap component as WordPress widget
 *
 * @author Junior Grossi <@jgrossi>
 * @see    http://getbootstrap.com/components/#wells
 */
class WPBW_Widget_Well extends WP_Widget {

	/**
	 * The image component constructor
	 */
	public function __construct() {
		parent::__construct(
			'wpbw-well',
			__( 'Well' ),
			array(
				'description'   => __( 'Give your content a simple inset effect.' ),
				'panels_groups' => array( 'wp-bootstrap-widgets' ),
				'panels_icon'   => 'dashicons dashicons-align-center',
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
		$content = isset( $instance['content'] ) ? $instance['content'] : '';
		$size    = isset( $instance['size'] ) ? $instance['size'] : '';
		echo $args['before_widget'];
		?>
		<div class="well <?php echo $size; ?>">
			<?php echo $content; ?>
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
		$this->form_field_content( $instance );
		$this->form_field_size( $instance );
	}

	/**
	 * The widget's content (HTML allowed)
	 *
	 * @param $instance
	 */
	public function form_field_content( $instance ) {
		$id    = $this->get_field_id( 'content' );
		$name  = $this->get_field_name( 'content' );
		$value = isset( $instance['content'] ) ? $instance['content'] : '';
		wpbw_field_text( $name, __( 'Content <em>(HTML code allowed)</em>:' ), compact( 'id' ), $value );
	}

	/**
	 * The widget's "type" class
	 *
	 * @param $instance
	 */
	public function form_field_size( $instance ) {
		$id      = $this->get_field_id( 'size' );
		$name    = $this->get_field_name( 'size' );
		$value   = isset( $instance['size'] ) ? $instance['size'] : '';
		$options = array(
			''        => 'Normal',
			'well-lg' => 'Large',
			'well-sm' => 'Small',
		);
		wpbw_field_select( $name, __( 'Size:' ), $options, compact( 'id' ), $value );
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
		$instance['content'] = preg_replace( '/<script.*?>.*?<\/script>/i', '', $new_instance['content'] );
		$instance['size']    = strip_tags( $new_instance['size'] );

		return $instance;
	}
}