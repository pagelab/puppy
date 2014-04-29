<?php

/**
 * Remove pages from search of site
 *
*/

function remove_pages_from_search() {
    	global $wp_post_types;
    	$wp_post_types['page']->exclude_from_search = true;
}

add_action('init', 'remove_pages_from_search');

/**
 * Custom Queries for different parts of the site
 *
*/
function kibble_wp_query($query) {

	 if ( !$query->is_admin && $query->is_home && $query->is_main_query()) {
		$query->set('posts_per_page', 12);
	 }

	 if ( !$query->is_admin && $query->is_home && $query->query_vars['paged'] >1) {
		$query->set('posts_per_page', 18);
	 }

	 if ( !$query->is_admin && $query->is_author) {
		$query->set('posts_per_page', 12);
	 }

	 if ( !$query->is_admin && $query->is_search) {
		$query->set('posts_per_page', -1);
		$query->set('orderby', 'date');
	 }

	 if ( !$query->is_admin && $query->is_tag) {
		$query->set('posts_per_page', -1);
		$query->set('orderby', 'date');
	 }

         return $query;
}

add_filter('pre_get_posts', 'kibble_wp_query'); 

