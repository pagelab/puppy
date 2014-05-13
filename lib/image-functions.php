<?php

/**
 * Custom HTML for the post thumbnail
 *
*/

function kibble_custom_thumbnail_html( $html, $post_id, $post_image_id ) {
	$title = get_the_title($post_id);
	if (empty( $html )) {
		$html = '<img width="180" title="'. $title .'" height="240" src="http://fakeimg.pl/164x204/282828/eae0d0/" class="thumbnail img-responsive" />';
	}
	$html = preg_replace(array('/(alt|title)=\"[^"]*"\s/','/class=\"[^"]*"\s/', '/width=\"[^"]*"\s/','/height=\"[^"]*"\s/'),array('title="'. $title .'" ','class="thumbnail img-responsive" ','width="180" ', 'height="240" '),trim($html));
    	return $html;
}

add_filter( 'post_thumbnail_html', 'kibble_custom_thumbnail_html', 10, 3 );

/**
 * Alter the markup for the gallery shortcode
 *
*/

function kibble_gallery_shortcode( $content, $attr ) {

    global $instance, $post;
    $instance++;

    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( ! $attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract( shortcode_atts( array(
        'order'            =>    'ASC',
        'orderby'        =>    'menu_order ID',
        'id'            =>    $post->ID,
        'itemtag'        =>    'figure',
        'icontag'        =>    'div',
        'captiontag'    =>    'figcaption',
        'columns'        =>    3,
        'size'            =>    'thumbnail',
        'include'        =>    '',
        'exclude'        =>    ''
    ), $attr ) );

    $id = intval( $id );

    if ( 'RAND' == $order ) {
        $orderby = 'none';
    }

    if ( $include ) {
        
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        
        $_attachments = get_posts( array(
            'include'            =>    $include,
            'post_status'        =>    'inherit',
            'post_type'            =>    'attachment',
            'post_mime_type'    =>    'image',
            'order'                =>    $order,
            'orderby'            =>    $orderby
        ) );

        $attachments = array();
        
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }

    } elseif ( $exclude ) {
        
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        
        $attachments = get_children( array(
            'post_parent'        =>    $id,
            'exclude'            =>    $exclude,
            'post_status'        =>    'inherit',
            'post_type'            =>    'attachment',
            'post_mime_type'    =>    'image',
            'order'                =>    $order,
            'orderby'            =>    $orderby
        ) );

    } else {

        $attachments = get_children( array(
            'post_parent'        =>    $id,
            'post_status'        =>    'inherit',
            'post_type'            =>    'attachment',
            'post_mime_type'    =>    'image',
            'order'                =>    $order,
            'orderby'            =>    $orderby
        ) );

    }

    if ( empty( $attachments ) ) {
        return;
    }

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
        return $output;
    }

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
 * Override the gallery shortcode markup
 *
*/

add_filter('post_gallery', 'kibble_gallery_shortcode', 10,2);
