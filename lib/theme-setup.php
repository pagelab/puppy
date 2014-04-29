<?php

/**
 * Register Menus, and post thumbnail support
 *
*/
function kibble_theme_setup() {
	register_nav_menu( 'primary', __( 'Navigation Menu', 'kibble' ) );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 164, 204, true );
	add_filter( 'use_default_gallery_style', '__return_false' );
}

add_action( 'after_setup_theme', 'kibble_theme_setup' );

