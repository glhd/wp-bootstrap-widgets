<?php

/**
 * The navbar Bootstrap component as WordPress widget
 *
 * @author Junior Grossi <@jgrossi>
 */
class WPBW_Widget_NavigationBar extends WP_Widget {

	/**
	 * The CSS class name when the <li> element has children (is a dropdown)
	 */
	const HAS_CHILDREN_CLASS = 'menu-item-has-children';

	/**
	 * The CSS class name when the <li> element is the current one
	 */
	const CURRENT_MENU_ITEM_CLASS = 'current-menu-item';

	/**
	 * The maximum depth for the navbar menu
	 */
	const MAX_DEPTH = 2;

	/**
	 * The navbar component constructor
	 */
	public function __construct() {
		parent::__construct(
			'wpbw-navbar',
			__( 'Navigation Bar' ),
			array(
				'description'   => __( 'Display a navbar component based on a WordPress menu.' ),
				'panels_groups' => array( 'wp-bootstrap-widgets' ),
				'panels_icon'   => 'dashicons dashicons-list-view',
			)
		);
		add_filter( 'nav_menu_css_class', array( $this, 'nav_menu_css_class' ), 10, 1 );
		add_filter( 'nav_menu_item_args', array( $this, 'nav_menu_item_args' ), 10, 3 );
		add_filter( 'nav_menu_link_attributes', array( $this, 'nav_menu_link_attributes' ), 10, 2 );
	}

	/**
	 * Add new classes to t he <li> menu item
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	public function nav_menu_css_class( $classes ) {
		if ( in_array( self::HAS_CHILDREN_CLASS, $classes ) ) {
			$classes[] = 'dropdown';
		}
		if ( in_array( self::CURRENT_MENU_ITEM_CLASS, $classes ) ) {
			$classes[] = 'active';
		}

		return $classes;
	}

	/**
	 * Add the caret to the dropdown <a> element
	 *
	 * @param stdClass $args
	 * @param WP_Post  $item
	 *
	 * @return mixed
	 */
	public function nav_menu_item_args( $args, $item, $depth ) {
		$args->link_after = ''; // remove link_after for others
		if ( in_array( self::HAS_CHILDREN_CLASS, $item->classes ) && $depth == 0 ) {
			$args->link_after = ' <span class="caret"></span>';
		}

		return $args;
	}

	/**
	 * Set the proper attributes for the dropdown <a> element
	 *
	 * @param array   $atts
	 * @param WP_Post $item
	 *
	 * @return mixed
	 */
	public function nav_menu_link_attributes( $atts, $item ) {
		if ( in_array( self::HAS_CHILDREN_CLASS, $item->classes ) ) {
			$atts['class']         = 'dropdown-toggle';
			$atts['data-toggle']   = 'dropdown';
			$atts['role']          = 'button';
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';
		}

		return $atts;
	}

	/**
	 * The widget output
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$menu  = isset( $instance['menu'] ) ? $instance['menu'] : 'primary';
		$color = isset( $instance['color'] ) ? $instance['color'] : 'navbar-default';
		echo $args['before_widget'];
		?>
		<nav class="navbar <?php echo $color; ?>">
			<div class="container-fluid">
				<?php echo $this->build_menu( $menu ); ?>
			</div>
		</nav>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Build the menu according Bootstrap conventions
	 *
	 * @param string $menu
	 *
	 * @return string
	 */
	public function build_menu( $menu ) {
		return wp_nav_menu( array(
			'menu'            => $menu,
			'menu_class'      => 'nav navbar-nav menu',
			'container_class' => 'collapse navbar-collapse',
			'echo'            => false,
			'depth'           => self::MAX_DEPTH,
			'walker'          => new WPBW_Widget_NavigationBar_Walker(),
		) );
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
		$this->form_field_color( $instance );
	}

	/**
	 * The image URL
	 *
	 * @param $instance
	 */
	public function form_field_menu( $instance ) {
		$id      = $this->get_field_id( 'menu' );
		$name    = $this->get_field_name( 'menu' );
		$value   = isset( $instance['menu'] ) ? $instance['menu'] : '';
		$label   = __( 'Menu:' );
		$options = $this->get_nav_menus();
		add_action( 'wpbw_field_after', array( $this, 'form_field_after' ) );
		wpbw_field_select( $name, $label, $options, compact( 'id' ), $value );
	}

	/**
	 * The navbar color class (default or inverse)
	 *
	 * @param $instance
	 */
	public function form_field_color( $instance ) {
		$id      = $this->get_field_id( 'color' );
		$name    = $this->get_field_name( 'color' );
		$value   = isset( $instance['color'] ) ? $instance['color'] : '';
		$options = array(
			'navbar-default' => 'Default',
			'navbar-inverse' => 'Inverse',
		);
		wpbw_field_select( $name, __( 'Color:' ), $options, compact( 'id' ), $value );
	}

	/**
	 * Get the registered and not registered menus
	 *
	 * @return array
	 */
	public function get_nav_menus() {
		$array = get_registered_nav_menus();
		$menus = wp_get_nav_menus();
		foreach ( $menus as $menu ) {
			$array[ $menu->slug ] = $menu->name;
		}

		return $array;
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
		$instance['menu']  = strip_tags( $new_instance['menu'] );
		$instance['color'] = strip_tags( $new_instance['color'] );

		return $instance;
	}

	/**
	 * Hook to customize after the field
	 *
	 * @param string $name
	 */
	public function form_field_after( $name ) {
		if ( $name == $this->get_field_name( 'menu' ) ) {
			$url = admin_url( 'nav-menus.php' );
			?>
			<span class="wpbw-highlight highlight">
				You can add new menus in ​<strong><a href="<?php echo $url; ?>">Appearance > Menus</a></strong>
			</span>
			<?php
		}
	}
}