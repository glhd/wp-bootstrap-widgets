<?php

/**
 * The "Responsive embed" Bootstrap component as WordPress widget
 *
 * @author Junior Grossi <@jgrossi>
 * @see    http://getbootstrap.com/components/#responsive-embed
 */
class WPBW_Widget_Embed extends WP_Widget {

	/**
	 * The image component constructor
	 */
	public function __construct() {
		parent::__construct(
			'wpbw-embed',
			__( 'Bootstrap Responsive Embed' ),
			array(
				'description'   => __( 'The "embed-responsive" Bootstrap component widget' ),
				'panels_groups' => array( 'wp-bootstrap-widgets' ),
				'panels_icon'   => 'dashicons dashicons-format-video',
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
		$aspect_ratio = isset( $instance['aspect_ratio'] ) ? $instance['aspect_ratio'] : 'embed-responsive-16by9';
		$iframe_src   = isset( $instance['src'] ) ? $instance['src'] : '';
		echo $args['before_widget'];
		?>
		<div class="embed-responsive <?php echo $aspect_ratio; ?>">
			<iframe class="embed-responsive-item" src="<?php echo $iframe_src; ?>"></iframe>
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
		$this->form_field_src( $instance );
		$this->form_field_aspect_ratio( $instance );
	}

	/**
	 * The widget's "src" attribute
	 *
	 * @param $instance
	 */
	public function form_field_src( $instance ) {
		$id    = $this->get_field_id( 'src' );
		$name  = $this->get_field_name( 'src' );
		$value = isset( $instance['src'] ) ? $instance['src'] : '';
		wpbw_field_text( $name, __( 'URL:' ), compact( 'id' ), $value );
	}

	/**
	 * The widget's "aspect ratio" option
	 *
	 * @param $instance
	 */
	public function form_field_aspect_ratio( $instance ) {
		$id      = $this->get_field_id( 'aspect_ratio' );
		$name    = $this->get_field_name( 'aspect_ratio' );
		$value   = isset( $instance['aspect_ratio'] ) ? $instance['aspect_ratio'] : '';
		$options = array(
			'embed-responsive-16by9' => '16x9',
			'embed-responsive-4by3'  => '4x3',
		);
		wpbw_field_select( $name, __( 'Aspect ratio:' ), $options, compact( 'id' ), $value );
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
		$instance                 = array();
		$instance['src']          = filter_var( $new_instance['src'], FILTER_VALIDATE_URL );
		$instance['aspect_ratio'] = strip_tags( $new_instance['aspect_ratio'] );

		return $instance;
	}
}