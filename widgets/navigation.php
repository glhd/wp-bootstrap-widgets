<?php

/**
 * The nav Bootstrap component as WordPress widget
 *
 * @author Junior Grossi <@jgrossi>
 */
class WPBW_Widget_Navigation extends WP_Widget {

	/**
	 * The image component constructor
	 */
	public function __construct() {
		parent::__construct(
			'wpbw-nav',
			__( 'Navigation' ),
			array(
				'description'   => __( 'Display an nav component based on a WordPress menu.' ),
				'panels_groups' => array( 'wp-bootstrap-widgets' ),
				'panels_icon'   => 'dashicons dashicons-list-view',
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
		$this->form_field_menu( $instance );
	}

	/**
	 * The image URL
	 *
	 * @param $instance
	 */
	public function form_field_menu( $instance ) {
		$id         = $this->get_field_id( 'menu' );
		$name       = $this->get_field_name( 'menu' );
		$value      = isset( $instance['menu'] ) ? $instance['menu'] : '#';
		$label      = __( 'Menu:' );
		$options    = get_registered_nav_menus();
		add_action( 'wpbw_field_after', array( $this, 'form_field_after' ) );
		wpbw_field_select( $name, $label, $options, compact('id'), $value );
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
		$instance         = array();
		$instance['menu'] = strip_tags( $new_instance['menu'] );

		return $instance;
	}

	/**
	 * Hook to customize after the field
	 *
	 * @param string $name
	 */
	public function form_field_after( $name ) {
		if ( $name == $this->get_field_name( 'menu' ) ) {
			$url = admin_url('nav-menus.php');
			?>
			<span class="highlight" style="padding: 5px 10px; font-style: italic; display: block; margin-top: 1em;">
				You can add new menus in ​<strong><a href="<?php echo $url; ?>">Appearance > Menus</a></strong>
			</span>
			<?php
		}
	}
}