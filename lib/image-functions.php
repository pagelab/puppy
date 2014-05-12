<?php

/**
 * Custom HTML for the post thumbnail
 *
*/

function kibble_custom_thumbnail_html( $html, $post_id, $post_image_id ) {
	$title = get_the_title($post_id);
	if (empty( $html )) {
		$html = '<img width="180" title="'. $title .'" height="240" src="http://baconpics.com/wp-content/uploads/2010/03/Bacon-164x204.jpg" class="thumbnail img-responsive" />';
	}
	$html = preg_replace(array('/(alt|title)=\"[^"]*"\s/','/class=\"[^"]*"\s/', '/width=\"[^"]*"\s/','/height=\"[^"]*"\s/'),array('title="'. $title .'" ','class="thumbnail img-responsive" ','width="180" ', 'height="240" '),trim($html));
    	return $html;
}

add_filter( 'post_thumbnail_html', 'kibble_custom_thumbnail_html', 10, 3 );

/**
 * Remove built in gallery shortcode
 *
*/
remove_shortcode('gallery');


/**
 * Add our own gallery shortcode 
 *
*/

function kibble_gallery_shortcode($attr) {

	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr, 'gallery'));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	$gallery_style = $gallery_div = '<div class="col-md-12">';
	$gallery_div = '<ul class="grid-view">' . "\n";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n" . $gallery_div );

    	foreach ( $attachments as $id => $attachment ) {
		$full_image = wp_get_attachment_url($id);
		$attachment_link = get_attachment_link($id);
		$thumbnail = wp_get_attachment_thumb_url($id);
		$title = trim($attachment->post_excerpt) ? wptexturize($attachment->post_excerpt) : $attachment->post_title;

		if(kibble_option('kibble_lightbox_type') == true) {
			$output .= "\t<li><a href=\"$full_image\" class=\"fresco\" data-fresco-group=\"gallery-{$post->ID}\">\n\t<img class=\"img-responsive thumbnail\" title=\"$title\" src=\"$thumbnail\" >\n\t</a>";
		}

		else {
			$output .= '<li><a href="'. $attachment_link .'"><img class="img-responsive thumbnail" src="'. $thumbnail .'"></a></li>' . "\n";
		}
	}
	$output .= "</ul>" . "\n";
	$output .= "</div>" . "\n";
	return $output;


}

/**
 * Add gallery shortcode overwriting the built in one
 *
*/

add_shortcode('gallery', 'kibble_gallery_shortcode');

