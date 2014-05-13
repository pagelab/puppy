<?php

/**
 * Add archive and category index pages
 *
*/

function kibble_create_pages(){

	$pages = array('channels', 'archives');

	foreach($pages as $page){
		$newpage_template = 'page-' . $page . '.php';

		$newpage_check = get_page_by_title($page);

		$newpage_page = array(
			'post_type' => 'page',
			'post_title' => $page,
			'post_status' => 'publish',
			'post_author' => 1,
		);

		if(!isset($newpage_check->ID)){
			$newpage_id = wp_insert_post($newpage_page);
			update_post_meta($newpage_id, '_wp_page_template', $newpage_template);
		}
	}
}

/**
 * Fire on theme setup
 *
*/

add_action( 'after_setup_theme', 'kibble_create_pages' );

