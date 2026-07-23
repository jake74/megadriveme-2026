<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package dekiru
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function dekiru_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	// if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	// 	$classes[] = 'no-sidebar';
	// }

	return $classes;
}
add_filter( 'body_class', 'dekiru_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function dekiru_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'dekiru_pingback_header' );

// Update CSS within in Admin
// function admin_style() {
//   wp_enqueue_style('admin-styles', get_template_directory_uri().'/admin.css');
// }
// add_action('admin_enqueue_scripts', 'admin_style');

// ACF options page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

// use js datepicker fallback
add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

// remove unwanted crap
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_filter( 'render_block', 'wp_render_elements_support', 10, 2 );
remove_filter( 'render_block', 'gutenberg_render_elements_support', 10, 2 );

add_action( 'wp_enqueue_scripts', 'remove_unwanted_styles' );
function remove_unwanted_styles(){
  wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'global-styles-inline-css' );
}

// remove gutenburg crap
function wps_deregister_styles() {
	wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );

// remove custom CSS
remove_action( 'wp_head', 'wp_custom_css_cb', 101 );
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );

// clean up dashboard
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {

global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
}


function move_yoast_to_bottom() {
    return 'low';
}
add_filter( 'wpseo_metabox_prio', 'move_yoast_to_bottom');


// Add X-Frame-Options header to prevent clickjacking
add_action( 'send_headers', 'send_frame_options_header', 10, 0 );
