<?php
/*
Plugin Name: Junaid Bhura Switch Blog Theme
Description: Switch the theme for blog pages
Version: 0.0.2
Author: Junaid Bhura
Author URI: http://www.junaidbhura.com
License: GPL
*/

// Set global variables
global $junaidbhura_my_theme;
global $pagenow;

// Create options
add_option( 'junaidbhura_sbt_default_theme' );
add_option( 'junaidbhura_sbt_blog_theme' );
add_option( 'junaidbhura_sbt_blog_base' );

// Get default theme from options
$default_theme = get_option( 'junaidbhura_sbt_default_theme' );
$blog_theme = get_option( 'junaidbhura_sbt_blog_theme' );
$blog_base = get_option( 'junaidbhura_sbt_blog_base' );

$junaidbhura_my_theme = $default_theme;

// If the options are not set, don't run this plugin
if ( $default_theme == '' || $blog_theme == '' || $blog_base == '' )
	$run_plugin = false;
else
	$run_plugin = true;

// Get URI
$uri_array = explode( '/', $_SERVER["REQUEST_URI"] );

// Check for blog
if ( $run_plugin && in_array( $blog_base , $uri_array ) )
	$junaidbhura_my_theme = $blog_theme;

// Check for Post in WP Admin
elseif ( is_admin() ) {
	if ( $pagenow == 'post.php' ) {
		if ( isset( $_GET['post'] ) && get_post_type( $_GET['post'] ) == 'post' )
			$junaidbhura_my_theme = $blog_theme;
	}
	elseif ( $pagenow == 'post-new.php' && !isset( $_GET['post_type'] ) )
		$junaidbhura_my_theme = $blog_theme;
}

// Add action to load our theme when all plugins are loaded
if ( $run_plugin )
	add_action( 'plugins_loaded', 'JunaidBhura_filters' );

// Add action to show options page
if ( is_admin() )
	add_action('admin_menu', 'junaidbhura_sbt_admin_menu');


/* -- DON'T EDIT BELOW THIS -- */

function junaidbhura_sbt_admin_menu() {
    add_options_page('Switch Blog Theme Options', 'Switch Blog Theme Options', 'manage_options','junaidbhura-sbt_options', 'junaidbhura_sbt_options_page' );
	add_action( 'admin_init', 'junaidbhura_sbt_register' );
}
 
function junaidbhura_sbt_register() {
	register_setting( 'junaidbhura-sbt_options', 'junaidbhura_sbt_default_theme' );
	register_setting( 'junaidbhura-sbt_options', 'junaidbhura_sbt_blog_theme' );
	register_setting( 'junaidbhura-sbt_options', 'junaidbhura_sbt_blog_base' );
}

function junaidbhura_sbt_options_page() {
	if ( !current_user_can( 'manage_options' ) )
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	
	require_once( plugin_dir_path( __FILE__ ) . 'options.php' );
}

function JunaidBhura_filters () {
	  add_filter( 'template', 'junaidbhura_get_template' );
	  add_filter( 'stylesheet', 'junaidbhura_get_stylesheet' );
}

function junaidbhura_whats_my_theme() {
	global $junaidbhura_my_theme;
	$theme = $junaidbhura_my_theme;
	$theme_data = get_theme( $theme );
	
	if ( !empty( $theme_data ) ) {
	
		if ( isset( $theme_data['Status'] ) && $theme_data['Status'] != 'publish' )
			return false;
		
		return $theme_data;
	}
	
	$themes = get_themes();
	
	foreach( $themes as $theme_data ) {
	
		if ( $theme_data['Stylesheet'] == $theme ) {
		
			if ( isset($theme_data['Status']) && $theme_data['Status'] != 'publish' )
				return false;
		
			return $theme_data;
		}
	}
	
	return false;
}

function junaidbhura_get_template( $template ) {
	$theme = junaidbhura_whats_my_theme();
	if ( $theme === false ) {
		return $template;
	}
	
	return $theme['Template'];
}

function junaidbhura_get_stylesheet( $stylesheet ) {
	$theme = junaidbhura_whats_my_theme();
	if ( $theme === false ) {
		return $stylesheet;
	}
	
	return $theme['Stylesheet'];
}
?>