<?php
/*
Plugin Name: WP Bootstrap Widgets
Plugin URI:  https://github.com/glhd/wp-bootstrap-widgets
Description: Bootstrap Components as WordPress Widgets
Version:     0.3.2
Author:      Galahad, Inc.
Author URI:  http://glhd.org/
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

define( 'WPBW_NAME', 'WP Bootstrap Widgets' );
define( 'WPBW_SLUG', 'wp-bootstrap-widgets' );
define( 'WPBW_URL', plugin_dir_url( __FILE__ ) );
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
	register_widget( 'WPBW_Widget_Alert' );
	register_widget( 'WPBW_Widget_Button' );
	register_widget( 'WPBW_Widget_Embed' );
	register_widget( 'WPBW_Widget_Image' );
	register_widget( 'WPBW_Widget_NavigationBar' );
	register_widget( 'WPBW_Widget_Panel' );
	register_widget( 'WPBW_Widget_Well' );
}

/**
 * Create a new tab for the Page Builder plugin
 *
 * @param $tabs
 *
 * @see https://siteorigin.com/page-builder/
 *
 * @return array
 */
function wpbw_add_widget_tabs( $tabs ) {
	$tabs[] = array(
		'title'  => __( 'Bootstrap Widgets' ),
		'filter' => array(
			'groups' => array( 'wp-bootstrap-widgets' ),
		),
	);

	return $tabs;
}

/**
 * Register the plugin CSS and JS files for admin panel
 */
function wpbw_assets_admin() {
	wp_enqueue_media(); // Media Library
	wp_enqueue_script( WPBW_SLUG, WPBW_URL . 'assets/scripts-admin.js', array( 'jquery' ) );
	wp_enqueue_style( WPBW_SLUG, WPBW_URL . 'assets/styles-admin.css' );
}

/**
 * Register the CSS and JS files for frontend layer
 */
function wpbw_assets_front() {
	wp_enqueue_style( WPBW_SLUG, WPBW_URL . 'assets/styles-front.css' );
	wp_enqueue_script( 'bootstrap-alert', WPBW_URL . 'assets/bootstrap/alert.js', array( 'jquery' ), '3.3.7', true );
	wp_enqueue_script( 'bootstrap-dropdown', WPBW_URL . 'assets/bootstrap/dropdown.js', array( 'jquery' ), '3.3.7', true );
}

/*
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise older PHP installations could crash when trying to parse it.
 */
if ( wpbw_requirements_met() ) {
	require_once( dirname( __FILE__ ) . '/form-fields.php' );
	require_once( dirname( __FILE__ ) . '/include/navigation-bar-walker.php' );
	require_once( dirname( __FILE__ ) . '/widgets/alert.php' );
	require_once( dirname( __FILE__ ) . '/widgets/button.php' );
	require_once( dirname( __FILE__ ) . '/widgets/embed.php' );
	require_once( dirname( __FILE__ ) . '/widgets/image.php' );
	require_once( dirname( __FILE__ ) . '/widgets/navigation-bar.php' );
	require_once( dirname( __FILE__ ) . '/widgets/panel.php' );
	require_once( dirname( __FILE__ ) . '/widgets/well.php' );

	add_action( 'widgets_init', 'wpbw_widgets_init' );
	add_action( 'admin_enqueue_scripts', 'wpbw_assets_admin' );
	add_action( 'wp_enqueue_scripts', 'wpbw_assets_front' );
	// Site Origin Page Builder Plugin
	if ( has_filter( 'siteorigin_panels_widget_dialog_tabs' ) ) {
		add_filter( 'siteorigin_panels_widget_dialog_tabs', 'wpbw_add_widget_tabs', 20 );
	}
} else {
	add_action( 'admin_notices', 'wpbw_requirements_error' );
}