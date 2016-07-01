/**
 * This script is used to load the WordPress media library for the .btn widget.
 * It uses a button to open the media library and allows the user to select the desired image.
 *
 * @see /widgets/img.php
 */
jQuery(document).ready(function ($) {
	if (typeof wp !== 'undefined' && wp.media) {
		var frame;
		$(document).on('click', '#wpbw-upload-button', function (e) {
			e.preventDefault();
			var button = $(this);
			if (frame) {
				frame.open();
				return;
			}
			frame = wp.media({
				title   : 'Select image',
				library : {
					type: 'image'
				},
				button  : {
					text: 'Select this image'
				},
				multiple: false
			});
			frame.on('select', function () {
				var attachment = frame.state().get('selection').first().toJSON();
				button.prev().val(attachment.url);
			});
			frame.open();
		});
	}
});