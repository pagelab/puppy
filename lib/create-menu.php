<?php

/**
 * Automatically Create nav menu with archives, category index, and category with children
 *
*/

function kibble_autocreate_menu() {

    	$menuname = 'Navigation Menu';

    	$kibble_menu_location = 'primary';

    	$menu_exists = wp_get_nav_menu_object( $menuname );

    	if( !$menu_exists){

        	$menu_id = wp_create_nav_menu($menuname);

    		wp_update_nav_menu_item($menu_id, 0, array(
        		'menu-item-title' =>  __('Home'),
        		'menu-item-classes' => 'home',
        		'menu-item-url' => home_url( '/' ),
        		'menu-item-status' => 'publish')
		);

    		$category_parent = wp_update_nav_menu_item($menu_id, 0, array(
        		'menu-item-title' =>  __('Categories'),
        		'menu-item-classes' => 'categories',
        		'menu-item-url' => home_url( '#' ),
        		'menu-item-status' => 'publish')
		);

    		$categories = get_categories();

    		foreach($categories as $category) {

    			wp_update_nav_menu_item($menu_id, 0, array(
        			'menu-item-title' =>  $category->name,
        			'menu-item-classes' => $category->name,
				'menu-item-object' => 'category',
				'menu-item-url' => get_category_link($category->term_id),
				'menu-item-parent-id' => $category_parent, 
        			'menu-item-status' => 'publish')
			);
    		}

    		wp_update_nav_menu_item($menu_id, 0, array(
        		'menu-item-title' =>  __('Category Index'),
        		'menu-item-classes' => 'categoryindex',
        		'menu-item-url' => home_url( '/channels/' ),
        		'menu-item-status' => 'publish')
		);

    		wp_update_nav_menu_item($menu_id, 0, array(
        		'menu-item-title' =>  __('Archives'),
        		'menu-item-classes' => 'archives',
        		'menu-item-url' => home_url( '/archives/' ),
        		'menu-item-status' => 'publish')
		);
	}

    	if( !has_nav_menu( $kibble_menu_location ) ){
        	$locations = get_theme_mod('nav_menu_locations');
        	$locations[$kibble_menu_location] = $menu_id;
        	set_theme_mod( 'nav_menu_locations', $locations );
    	}
}

/**
 * Autocreate the menu on theme activate
 *
*/
add_action('after_switch_theme', 'kibble_autocreate_menu');

/**
 * Set Custom thumbnail size automatically
 *
*/

function kibble_check_thumbnail_size() {

     if(false === get_option("thumbnail_crop")) {
          add_option("thumbnail_crop", "1"); 
     }

     else {
          update_option("thumbnail_crop", "1");
     }

     if(get_option('thumbnail_size_w') != 120)
          update_option('thumbnail_size_w',120);
     if(get_option('thumbnail_size_h') != 160)
          update_option('thumbnail_size_h',160);
 }

/**
 * Change thumbnail sizes on activate
 *
*/

add_action('after_switch_theme', 'kibble_check_thumbnail_size');
