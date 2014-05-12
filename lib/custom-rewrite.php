<?php

/**
 * Add Custom attachment rewrite rules, and rewrite assets (js,css,images)
 *
*/

function kibble_add_rewrite_rules( $wp_rewrite ) { 

    	global $wp_rewrite;

  	$new_rules = array(
        	"^media/(\d*)/(.+)\$"  => 'index.php?attachment_id=' . $wp_rewrite->preg_index(1)

  	);

    	$wp_rewrite->rules = $new_rules + $wp_rewrite->rules; 
}

add_action('generate_rewrite_rules', 'kibble_add_rewrite_rules'); 

/**
 * Flush rewrites
 *
*/

function puppy_flush_rewrite_rules() {
	global $pagenow, $wp_rewrite;

	if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
		$wp_rewrite->flush_rules();
}

add_action( 'load-themes.php', 'puppy_flush_rewrite_rules' );

/**
 * Change the default attachment link to the new one
 *
*/

function attachment_change_link( $link, $id ) {
        global $post;
        $slug = sanitize_title(get_the_title($post->post_parent));
        return home_url("/media/$id/$slug");
}

add_filter('attachment_link', 'attachment_change_link', 10, 2 );

/**
 * Change the default search url
 *
*/

function change_search_url_rewrite() {
	if ( is_search() && ! empty( $_GET['s'] ) ) {
		wp_redirect( home_url( "/search/" ) . urlencode( get_query_var( 's' ) ) );
		exit();
	}
}

add_action( 'template_redirect', 'change_search_url_rewrite' );


