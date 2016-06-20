<?php

/**
 * The image Bootstrap component as WordPress widget
 *
 * @author Junior Grossi <@jgrossi>
 */
class WPBW_Widget_Image extends WP_Widget {

	/**
	 * The image component constructor
	 */
	public function __construct() {
		parent::__construct(
			'wpbw-img',
			__( 'Bootstrap Image' ),
			array( 'description' => __( 'The image Bootstrap component widget' ) )
		);
	}

	/**
	 * The widget output
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$classes = $instance['responsive'];
		$classes .= ' ' . $instance['shape'];
		$alt = $instance['alt'];
		$url = isset( $instance['url'] ) ? $instance['url'] : '';
		echo $args['before_widget'];
		?>
		<img src="<?php echo $url; ?>" class="<?php echo $classes; ?>" alt="<?php echo $alt; ?>" />
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
		$this->form_field_url( $instance );
		$this->form_field_alt( $instance );
		$this->form_field_responsive( $instance );
		$this->form_field_shape( $instance );
	}

	/**
	 * The image URL
	 *
	 * TODO: Use a button to select the image in the library instead of the URL
	 *
	 * @param $instance
	 */
	public function form_field_url( $instance ) {
		$id    = $this->get_field_id( 'url' );
		$name  = $this->get_field_name( 'url' );
		$value = isset( $instance['url'] ) ? $instance['url'] : '#';
		wpbw_field_text( $name, __( 'Image URL:' ), compact( 'id' ), $value );
	}

	/**
	 * The image alt attribute
	 *
	 * @param $instance
	 */
	public function form_field_alt( $instance ) {
		$id    = $this->get_field_id( 'alt' );
		$name  = $this->get_field_name( 'alt' );
		$value = isset( $instance['alt'] ) ? $instance['alt'] : 'My image';
		wpbw_field_text( $name, __( 'Alternate text:' ), compact( 'id' ), $value );
	}

	/**
	 * The image responsive class
	 *
	 * @param $instance
	 */
	public function form_field_responsive( $instance ) {
		$id      = $this->get_field_id( 'responsive' );
		$name    = $this->get_field_name( 'responsive' );
		$value   = isset( $instance['responsive'] ) ? $instance['responsive'] : '';
		$options = array(
			''               => 'Normal image',
			'img-responsive' => 'Responsive image',
		);
		wpbw_field_select( $name, __( 'Variations:' ), $options, compact( 'id' ), $value );
	}

	/**
	 * The image shape class
	 *
	 * @param $instance
	 */
	public function form_field_shape( $instance ) {
		$id      = $this->get_field_id( 'shape' );
		$name    = $this->get_field_name( 'shape' );
		$value   = isset( $instance['shape'] ) ? $instance['shape'] : '';
		$options = array(
			''              => 'No special shape',
			'img-rounded'   => 'Rounded image',
			'img-circle'    => 'Circle image',
			'img-thumbnail' => 'Thumbnail image',
		);
		wpbw_field_select( $name, __( 'Shape:' ), $options, compact( 'id' ), $value );
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
		$instance               = array();
		$instance['url']        = filter_var( $new_instance['url'], FILTER_VALIDATE_URL );
		$instance['alt']        = strip_tags( $new_instance['alt'] );
		$instance['responsive'] = strip_tags( $new_instance['responsive'] );
		$instance['shape']      = strip_tags( $new_instance['shape'] );

		return $instance;
	}
}