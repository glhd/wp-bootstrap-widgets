<?php

/**
 * Text field for widget settings
 *
 * @param        $name
 * @param        $text
 * @param array  $attributes
 * @param string $value
 */
function wpbw_field_text( $name, $text, $attributes = array(), $value = '' ) {
	$id    = $attributes['id'];
	$class = isset( $attributes['class'] ) ? $attributes['class'] : 'widefat';
	$placeholder = isset( $attributes['placeholder'] ) ? $attributes['placeholder'] : '';
	?>
	<p>
		<label for="<?php echo $id; ?>"><?php echo $text; ?></label>
		<?php do_action( 'wpbw_field_before', $name ); ?>
		<input class="<?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $name; ?>" type="text" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>" />
		<?php do_action( 'wpbw_field_after', $name ); ?>
	</p>
	<?php
}

/**
 * Textarea field for widget settings
 *
 * @param        $name
 * @param        $text
 * @param array  $attributes
 * @param string $value
 */
function wpbw_field_textarea( $name, $text, $attributes = array(), $value = '' ) {
	$id = $attributes['id'];
	unset( $attributes['id'] );
	$class = isset( $attributes['class'] ) ? $attributes['class'] : 'widefat';
	unset( $attributes['class'] );
	$html = '';
	foreach ( $attributes as $key => $val ) {
		$html .= sprintf( '%s="%s" ', $key, $val );
	}
	?>
	<p>
		<label for="<?php echo $id; ?>"><?php echo $text; ?></label>
		<?php do_action( 'wpbw_field_before', $name ); ?>
		<textarea class="<?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $name; ?>" <?php echo $html; ?>><?php echo $value; ?></textarea>
		<?php do_action( 'wpbw_field_after', $name ); ?>
	</p>
	<?php
}

/**
 * Select field for widget settings
 *
 * @param        $name
 * @param        $text
 * @param        $options
 * @param array  $attributes
 * @param string $value
 */
function wpbw_field_select( $name, $text, $options, $attributes = array(), $value = '' ) {
	$id    = $attributes['id'];
	$class = isset( $attributes['class'] ) ? $attributes['class'] : '';
	?>
	<p>
		<label for="<?php echo $id; ?>"><?php echo $text; ?></label>
		<?php do_action( 'wpbw_field_before', $name ); ?>
		<select name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class; ?>">
			<?php foreach ( $options as $key => $option ): ?>
				<?php $selected = ( $key == $value ) ? 'selected="selected"' : ''; ?>
				<option value="<?php echo $key; ?>" <?php echo $selected; ?>>
					<?php echo $option; ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php do_action( 'wpbw_field_after', $name ); ?>
	</p>
	<?php
}