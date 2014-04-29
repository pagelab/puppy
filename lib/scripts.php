<?php

/**
 * Enqueue styles and javascripts
 *
*/

function gallery_scripts_init() {

	global $post;

	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '1.0', true);
	wp_localize_script('bootstrap', 'VOTING', array('base_url'  => esc_url(home_url()),));

	if(is_page('archives')) {
		wp_enqueue_script('bootstrap_select', get_stylesheet_directory_uri() . '/js/bootstrap-select.min.js', array('jquery'), null, true);
		wp_enqueue_script('ajax_dropdown', get_stylesheet_directory_uri() . '/js/loadposts.js',array('jquery'));
		wp_localize_script('ajax_dropdown', 'myajax', array('custom_nonce' => wp_create_nonce('nonce-ajax-dropdown'), 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	if(is_single() && get_post_meta($post->ID,'_kibble_video',true) == true) {
		wp_enqueue_style('videojs_css', 'http://vjs.zencdn.net/4.2/video-js.css');
		wp_enqueue_script('videojs_skin', 'http://vjs.zencdn.net/4.2/video.js', null, null, true);
		wp_enqueue_script('videojs_youtube', get_stylesheet_directory_uri() . '/js/media.youtube.js', null, null, true);
	}

	if(kibble_option('kibble_lightbox_type') == true) {
		wp_enqueue_script('frescojs', get_template_directory_uri() . '/js/fresco.js', array('jquery'), '1.0');
		wp_enqueue_style('frescocss', get_template_directory_uri() . '/css/fresco.css');

		global $is_IE;
    		if( $is_IE ) {
			wp_enqueue_script( 'css3_media_queries', 'http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js');
		}

	}
}

add_action('wp_enqueue_scripts', 'gallery_scripts_init');

function remove_script_versions() {
	global $wp_scripts;
	if ( !is_a( $wp_scripts, 'WP_Scripts' ) )
		return;
	foreach ( $wp_scripts->registered as $handle => $script )
		$wp_scripts->registered[$handle]->ver = null;
}

function remove_style_versions() {
	global $wp_styles;
	if ( !is_a( $wp_styles, 'WP_Styles' ) )
		return;
	foreach ( $wp_styles->registered as $handle => $style )
		$wp_styles->registered[$handle]->ver = null;
}

add_action( 'wp_print_scripts', 'remove_script_versions', 100 );
add_action( 'wp_print_footer_scripts', 'remove_script_versions', 100 );
add_action( 'wp_print_styles', 'remove_style_versions', 100 );

add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );

function remove_jquery_migrate( &$scripts){
	$scripts->remove( 'jquery');
	$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
}

