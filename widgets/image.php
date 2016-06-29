<?php

/**
 * The image Bootstrap component as WordPress widget
 *
 * @author Junior Grossi <@jgrossi>
 * @todo Add set dimensions
 */
class WPBW_Widget_Image extends WP_Widget {

	/**
	 * The image component constructor
	 */
	public function __construct() {
		parent::__construct(
			'wpbw-image',
			__( 'Image' ),
			array(
				'description'   => __( 'Display an image with styling and responsive resizing.' ),
				'panels_groups' => array( 'wp-bootstrap-widgets' ),
				'panels_icon'   => 'dashicons dashicons-format-image',
			)
		);
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	public function admin_scripts() {
		wp_enqueue_media();
		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . '../js/image.js', array( 'jquery' ) );
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
	 * @param $instance
	 */
	public function form_field_url( $instance ) {
		$id         = $this->get_field_id( 'url' );
		$name       = $this->get_field_name( 'url' );
		$value      = isset( $instance['url'] ) ? $instance['url'] : '#';
		$label      = __( 'Image <em>(select from media library or paste the URL)</em>:' );
		$attributes = array( 'id' => $id, 'class' => '' );
		add_action( 'wpbw_field_before', array( $this, 'form_field_before' ) );
		add_action( 'wpbw_field_after', array( $this, 'form_field_after' ) );
		wpbw_field_text( $name, $label, $attributes, $value );
	}

	/**
	 * The image alt attribute
	 *
	 * @param $instance
	 */
	public function form_field_alt( $instance ) {
		$id    = $this->get_field_id( 'alt' );
		$name  = $this->get_field_name( 'alt' );
		$value = isset( $instance['alt'] ) ? $instance['alt'] : '';
		$placeholder = 'eg. Photo of cat pouncing';
		wpbw_field_text( $name, __( 'Descriptive Text (alt):' ), compact( 'id', 'placeholder' ), $value );
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
			''               => 'Fixed Size',
			'img-responsive' => 'Responsive (scales up or down to fit container)',
		);
		wpbw_field_select( $name, __( 'Responsive:' ), $options, compact( 'id' ), $value );
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
			''              => 'No Special Shape',
			'img-rounded'   => 'Rounded Corners',
			'img-circle'    => 'Circle',
			'img-thumbnail' => 'Thumbnail',
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

	/**
	 * Hook to customize before the field
	 *
	 * @param string $name
	 */
	public function form_field_before( $name ) {
		if ( $name == $this->get_field_name( 'url' ) ) {
			echo '<br>';
		}
	}

	/**
	 * Hook to customize after the field
	 *
	 * @param string $name
	 */
	public function form_field_after( $name ) {
		if ( $name == $this->get_field_name( 'url' ) ) {
			?>
			<input id="wpbw-upload-button" type="button" class="button" value="Choose from Media Library" />
			<?php
		}
	}
}