<?php

/**
 * check if post has a thumbnail
 *
*/

function kibble_check_for_thumbnail($data, $postarr) {
	global $pagenow;

  	if (! empty($pagenow) && ('post-new.php' === $pagenow || 'post.php' === $pagenow )) {

  		if ($postarr['ID'] > 0 && $postarr['post_type'] == 'post') {
    			$pid = $postarr['ID'];

      			if (!has_post_thumbnail($pid)) {
        			add_filter('redirect_post_location', 'kibble_redirect_thumb', 99);
        			$data['post_status'] = 'draft';
      			}
    		}
	}
  	return $data;
}

add_filter('wp_insert_post_data', 'kibble_check_for_thumbnail', 99, 2);

/**
 * callback for redirect custom message
 *
*/

function kibble_redirect_thumb($loc) {
        $loc = remove_query_arg('message', $loc);
        $loc = add_query_arg('custom_message', kibble_custom_post_message(), $loc);
        remove_filter('redirect_post_location', __FUNCTION__, 99);
        return $loc;
}

/**
 * Add a custom message if no thumbnail is set
 *
*/

function kibble_custom_post_message() {
    $msg = __('Your post does not have a featured thumbnail, The post was saved as a draft and not published.', 'kibble');
    return urlencode($msg);
}

function kibble_custom_message_print() {
  echo '<div id="message" class="error"><p>'.urldecode($_GET['custom_message']).'</p></div>';
}

/**
 * hook the custom message into admin notices with red error
 *
*/

if (isset($_GET['custom_message']) AND !empty($_GET['custom_message'])) {
  add_action('admin_notices', 'kibble_custom_message_print');
}


