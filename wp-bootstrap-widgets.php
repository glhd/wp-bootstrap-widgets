<?php
/*
Plugin Name: WP Bootstrap Widgets
Plugin URI:  https://github.com/glhd/wp-bootstrap-widgets
Description: Bootstrap components as WordPress widgets
Version:     0.1
Author:      Galahad, Inc.
Author URI:  http://glhd.org/
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

define( 'WBW_NAME', 'WP Bootstrap Widgets' );
define( 'WBW_REQUIRED_PHP_VERSION', '5.2' );
define( 'WBW_REQUIRED_WP_VERSION', '3.0' );

/**
 * Checks if the system requirements are met
 *
 * @return bool True if system requirements are met, false if not
 */
function wbw_requirements_met() {
	global $wp_version;
	if ( version_compare( PHP_VERSION, WBW_REQUIRED_PHP_VERSION, '<' ) ) {
		return false;
	}
	if ( version_compare( $wp_version, WBW_REQUIRED_WP_VERSION, '<' ) ) {
		return false;
	}

	return true;
}

/**
 * Prints an error that the system requirements weren't met.
 */
function wbw_requirements_error() {
	global $wp_version;
	require_once( dirname( __FILE__ ) . '/views/requirements-error.php' );
}

/*
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise older PHP installations could crash when trying to parse it.
 */
if ( wbw_requirements_met() ) {
	require_once( __DIR__ . '/widgets/btn.php' );
	require_once( __DIR__ . '/widgets/img.php' );
	require_once( __DIR__ . '/widgets/alert.php' );
	require_once( __DIR__ . '/widgets/panel.php' );
	require_once( __DIR__ . '/widgets/embed-responsive.php' );
	require_once( __DIR__ . '/widgets/well.php' );
} else {
	add_action( 'admin_notices', 'wbw_requirements_error' );
}