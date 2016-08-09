<?php

/**
 * The "Responsive embed" Bootstrap component as WordPress widget
 *
 * @author Junior Grossi <@jgrossi>
 * @see    http://getbootstrap.com/components/#responsive-embed
 */
class WPBW_Widget_Embed extends WP_Widget {

	/**
	 * The responsive item class name
	 */
	const ITEM_CLASS = 'embed-responsive-item';

	/**
	 * The embed responsive constructor
	 */
	public function __construct() {
		parent::__construct(
			'wpbw-embed',
			__( 'Responsive Embed' ),
			array(
				'description'   => __( 'Allow browsers to determine video or slideshow dimensions based on the width of their container.' ),
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
		$code         = isset( $instance['code'] ) ? $instance['code'] : '';
		$title        = isset( $instance['title'] ) ? $instance['title'] : '';
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
		<div class="embed-responsive <?php echo $aspect_ratio; ?>">
			<?php echo $code; ?>
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
		$this->form_field_title( $instance );
		$this->form_field_code( $instance );
		$this->form_field_aspect_ratio( $instance );
	}

	/**
	 * @param $instance
	 */
	public function form_field_title( $instance ) {
		$id    = $this->get_field_id( 'title' );
		$name  = $this->get_field_name( 'title' );
		$value = isset( $instance['title'] ) ? $instance['title'] : '';
		wpbw_field_text( $name, __( 'Title <em>(optional)</em>:' ), compact( 'id' ), $value );
	}

	/**
	 * The widget's embed code
	 *
	 * @param $instance
	 */
	public function form_field_code( $instance ) {
		$id         = $this->get_field_id( 'code' );
		$name       = $this->get_field_name( 'code' );
		$value      = isset( $instance['code'] ) ? $instance['code'] : '';
		$attributes = array(
			'id'          => $id,
			'rows'        => 4,
			'placeholder' => htmlentities( '<iframe src="..."></iframe>' ),
		);
		wpbw_field_textarea( $name, __( 'Embed Code:' ), $attributes, $value );
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
			'embed-responsive-16by9' => '16x9 (widescreen)',
			'embed-responsive-4by3'  => '4x3 (traditional)',
		);
		wpbw_field_select( $name, __( 'Aspect Ratio:' ), $options, compact( 'id' ), $value );
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
		$instance['code']         = $this->filter_code_field( $new_instance['code'] );
		$instance['aspect_ratio'] = strip_tags( $new_instance['aspect_ratio'] );
		$instance['title']        = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Filter the iframe code to add the bootstrap item class and remove
	 * width and height attributes.
	 *
	 * @param string $code
	 *
	 * @return mixed|string
	 */
	protected function filter_code_field( $code ) {
		$code          = strip_tags( $code, '<iframe>' );
		$class_pattern = '/class=["\'](.+?)["\']/';
		preg_match( $class_pattern, $code, $class_matches );
		$classes = array();
		if ( isset( $class_matches[1] ) && $class_matches[1] ) { // class1 class2
			$classes = explode( ' ', trim( $class_matches[1] ) );
		}
		if ( ! in_array( static::ITEM_CLASS, $classes ) ) {
			$classes[] = static::ITEM_CLASS;
		}
		if ( isset( $class_matches[0] ) && $class_matches[0] ) { // class="class1 class2"
			$code = str_replace( $class_matches[0], '', $code );
		}
		$class_attribute = sprintf( 'class="%s"', implode( ' ', $classes ) );
		$code            = preg_replace( '/<iframe/i', '<iframe ' . $class_attribute, $code );
		$code            = preg_replace( '/(width|height)=["\'].+?["\']/', '', $code );
		$code            = preg_replace( '/\s\s+/', ' ', $code );

		return $code;
	}
}