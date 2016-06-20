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
	$class = isset( $attributes['class'] ) ? $attributes['class'] : '';
	?>
	<p>
		<label for="<?php echo $id; ?>"><?php echo $text; ?></label>
		<input class="widefat <?php echo $class; ?>" id="<?php echo $id; ?>"
		       name="<?php echo $name; ?>" type="text" value="<?php echo $value; ?>" />
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
	$class = isset( $attributes['class'] ) ? $attributes['class'] : '';
	unset( $attributes['class'] );
	$html = '';
	foreach ( $attributes as $key => $val ) {
		$html .= sprintf( '%s="%s" ', $key, $val );
	}
	?>
	<p>
		<label for="<?php echo $id; ?>"><?php echo $text; ?></label>
		<textarea class="widefat <?php echo $class; ?>" id="<?php echo $id; ?>"
		          name="<?php echo $name; ?>" <?php echo $html; ?>><?php echo $value; ?></textarea>
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
		<select name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class; ?>">
			<?php foreach ( $options as $key => $option ): ?>
				<?php $selected = ( $key == $value ) ? 'selected="selected"' : ''; ?>
				<option value="<?php echo $key; ?>" <?php echo $selected; ?>>
					<?php echo $option; ?>
				</option>
			<?php endforeach; ?>
		</select>
	</p>
	<?php
}