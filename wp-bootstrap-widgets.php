<?php
/*
Plugin Name: WP Bootstrap Widgets
Plugin URI:  https://github.com/glhd/wp-bootstrap-widgets
Description: Bootstrap Components as WordPress Widgets
Version:     0.1
Author:      Galahad, Inc.
Author URI:  http://glhd.org/
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

define( 'WPBW_NAME', 'WP Bootstrap Widgets' );
define( 'WPBW_REQUIRED_PHP_VERSION', '5.2' );
define( 'WPBW_REQUIRED_WP_VERSION', '3.0' );

/**
 * Checks if the system requirements are met
 *
 * @return bool True if system requirements are met, false if not
 */
function wpbw_requirements_met() {
	global $wp_version;
	if ( version_compare( PHP_VERSION, WPBW_REQUIRED_PHP_VERSION, '<' ) ) {
		return false;
	}
	if ( version_compare( $wp_version, WPBW_REQUIRED_WP_VERSION, '<' ) ) {
		return false;
	}

	return true;
}

/**
 * Prints an error that the system requirements weren't met.
 */
function wpbw_requirements_error() {
	global $wp_version;
	require_once( dirname( __FILE__ ) . '/views/requirements-error.php' );
}

/**
 * Register the widgets in WordPress
 */
function wpbw_widgets_init() {
	register_widget( 'WPBW_Widget_Button' );
}

/*
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise older PHP installations could crash when trying to parse it.
 */
if ( wpbw_requirements_met() ) {
	require_once( dirname( __FILE__ ) . '/form-fields.php' );
	require_once( dirname( __FILE__ ) . '/widgets/btn.php' );
	require_once( dirname( __FILE__ ) . '/widgets/img.php' );
	require_once( dirname( __FILE__ ) . '/widgets/alert.php' );
	require_once( dirname( __FILE__ ) . '/widgets/panel.php' );
	require_once( dirname( __FILE__ ) . '/widgets/embed-responsive.php' );
	require_once( dirname( __FILE__ ) . '/widgets/well.php' );

	add_action( 'widgets_init', 'wpbw_widgets_init' );

} else {
	add_action( 'admin_notices', 'wpbw_requirements_error' );
}