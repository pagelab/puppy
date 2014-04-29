<?php

/**
 * Add metabox for video embeds
 *
*/

function kibble_video_box() {
    $screens = array( 'post', 'page' );
    foreach ( $screens as $screen ) {
        add_meta_box('kibble_video_id', __( 'Video Embed', 'kibble' ), 'kibble_video_box_callback', $screen);
    }
}

add_action( 'add_meta_boxes', 'kibble_video_box' );

/**
 * Callback for input field for video embed meta box
 *
*/

function kibble_video_box_callback( $post ) {
  	$value = get_post_meta( $post->ID, '_kibble_video', true );
  	echo '<label for="kibble_video">URL:</label> <input type="text" id="kibble_video" name="kibble_video" value="' . esc_attr( $value ) . '" size="45" />';
}

/**
 * Saves the embed url on publish
 *
*/

function kibble_video_save_postdata( $post_id ) {
  	$mydata = sanitize_text_field( $_POST['kibble_video'] );
  	update_post_meta( $post_id, '_kibble_video', $mydata );
}

add_action( 'save_post', 'kibble_video_save_postdata' );

