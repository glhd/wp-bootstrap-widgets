<?php

/**
 * The "panel" Bootstrap component as WordPress widget
 *
 * @author Junior Grossi <@jgrossi>
 * @see    http://getbootstrap.com/components/#panels
 */
class WPBW_Widget_Panel extends WP_Widget {

	/**
	 * The image component constructor
	 */
	public function __construct() {
		parent::__construct(
			'wpbw-panel',
			__( 'Panel' ),
			array(
				'description'   => __( 'Highlight your content with a title bar and some special styling.' ),
				'panels_groups' => array( 'wp-bootstrap-widgets' ),
				'panels_icon'   => 'dashicons dashicons-editor-kitchensink',
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
		$class = isset( $instance['type'] ) ? $instance['type'] : 'panel-default';
		echo $args['before_widget'];
		?>
		<div class="panel <?php echo $class; ?>">
			<?php if ( isset( $instance['title'] ) and $instance['title'] ): ?>
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $instance['title']; ?></h3>
				</div>
			<?php endif; ?>
			<div class="panel-body">
				<?php echo isset( $instance['body'] ) ? $instance['body'] : ''; ?>
			</div>
			<?php if ( isset( $instance['footer'] ) and $instance['footer'] ): ?>
				<div class="panel-footer">
					<?php echo $instance['footer']; ?>
				</div>
			<?php endif; ?>
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
		$this->form_field_body( $instance );
		$this->form_field_footer( $instance );
		$this->form_field_type( $instance );
	}

	/**
	 * The panel's title
	 *
	 * @param $instance
	 */
	public function form_field_title( $instance ) {
		$id    = $this->get_field_id( 'title' );
		$name  = $this->get_field_name( 'title' );
		$value = isset( $instance['title'] ) ? $instance['title'] : '';
		wpbw_field_text( $name, __( 'Title <em>(optional)</em>:' ), compact( 'id' ), $value );
	}

	/**
	 * The panel's title
	 *
	 * @param $instance
	 */
	public function form_field_body( $instance ) {
		$id         = $this->get_field_id( 'body' );
		$name       = $this->get_field_name( 'body' );
		$value      = isset( $instance['body'] ) ? $instance['body'] : '';
		$attributes = array( 'id' => $id, 'rows' => 4 );
		wpbw_field_textarea( $name, __( 'Body <em>(HTML code allowed)</em>):' ), $attributes, $value );
	}

	/**
	 * The panel's footer
	 *
	 * @param $instance
	 */
	public function form_field_footer( $instance ) {
		$id    = $this->get_field_id( 'footer' );
		$name  = $this->get_field_name( 'footer' );
		$value = isset( $instance['footer'] ) ? $instance['footer'] : '';
		wpbw_field_text( $name, __( 'Footer <em>(optional)</em>:' ), compact( 'id' ), $value );
	}

	/**
	 * The panel's classes
	 *
	 * @param $instance
	 */
	public function form_field_type( $instance ) {
		$id      = $this->get_field_id( 'type' );
		$name    = $this->get_field_name( 'type' );
		$value   = isset( $instance['type'] ) ? $instance['type'] : '';
		$options = array(
			'panel-default' => 'Default',
			'panel-success' => 'Success',
			'panel-info'    => 'Info',
			'panel-warning' => 'Warning',
			'panel-danger'  => 'Danger',
		);
		wpbw_field_select( $name, __( 'Style:' ), $options, compact( 'id' ), $value );
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
		$instance           = array();
		$instance['title']  = strip_tags( $new_instance['title'] );
		$instance['body']   = preg_replace( '/<script.*?>.*?<\/script>/i', '', $new_instance['body'] );
		$instance['footer'] = strip_tags( $new_instance['footer'] );
		$instance['type']   = strip_tags( $new_instance['type'] );

		return $instance;
	}
}