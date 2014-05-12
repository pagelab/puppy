<?php

//add_action('the_content','kibble_vote_add_to_content');

function kibble_vote_add_to_content($content) {
    if ( is_singular('post') ) {
        global $post;
        $content .= kibblevote_votes();
    }
    return $content;
}

function kibblevote_votes($is_ajax = FALSE) {

    global $post;
    $votes_like = (int) get_post_meta($post->ID, '_votes_likes', true);
    $votes_dislike = (int) get_post_meta($post->ID, '_votes_dislikes', true);

    $vote_like_link = __("I like this", 'pressapps');
    $vote_dislike_link = __("I hate this", 'pressapps');
    $voted_like_single = __("person liked this", 'pressapps');
    $voted_dislike_single = __("person hated this", 'pressapps');
    $voted_like_plural = __("people liked this", 'pressapps');
    $voted_dislike_plural = __("people hated this", 'pressapps');
    $voted_like = sprintf(_n('%s ' . $voted_like_single, '%s ' . $voted_like_plural, $votes_like, 'pressapps'), $votes_like);
    $voted_dislike  = sprintf(_n('%s ' . $voted_dislike_single, '%s ' . $voted_dislike_plural, $votes_dislike, 'pressapps'), $votes_dislike);
    $cookie_vote_count      = '';
    $like_icon = '<i class="kibbleicon-thumbs-up-alt"></i> ';
    $dislike_icon = '<i class="kibbleicon-thumbs-down-alt"></i> ';

    if(isset($_COOKIE['vote_count'])){
        $cookie_vote_count = @unserialize(base64_decode($_COOKIE['vote_count']));
    }

    if(!is_array($cookie_vote_count) && isset($cookie_vote_count)){
        $cookie_vote_count = array();
    }

    $html = (($is_ajax)?'':'<div class="kibble-votes">');

            if(is_user_logged_in())
                $vote_count = (array) get_user_meta(get_current_user_id(), 'vote_count', true);
            else
                $vote_count = $cookie_vote_count;

            if (!in_array( $post->ID, $vote_count )) :

                    $html .= '<p class="kibble-likes"><a class="kibble-like_btn" href="javascript:" post_id="'  . $post->ID . '">'. $like_icon . $vote_like_link . '</a></p>';
                    $html .= '<p class="kibble-dislikes"><a class="kibble-dislike_btn" href="javascript:" post_id="' . $post->ID . '">' . $dislike_icon . $vote_dislike_link . '</a></p>';

            else :
                    $html .= '<p class="kibble-likes">'. $like_icon  . $voted_like . '</p> ';
                    $html .= '<p class="kibble-dislikes">' . $dislike_icon . $voted_dislike . '</p> ';
            endif;

    $html .= (($is_ajax)?'':'</div>');


	if ( $is_ajax ) {
		echo $html;
	} else {
		return $html;
	}
}

function kibblevote_vote() {
    global $post;

    if (is_user_logged_in()) {

        $vote_count = (array) get_user_meta(get_current_user_id(), 'vote_count', true);

        if (isset( $_GET['kibble-vote_like'] ) && $_GET['kibble-vote_like']>0) :

                $post_id = (int) $_GET['kibble-vote_like'];
                $the_post = get_post($post_id);

                if ($the_post && !in_array( $post_id, $vote_count )) :
                        $vote_count[] = $post_id;
                        update_user_meta(get_current_user_id(), 'vote_count', $vote_count);
                        $post_votes = (int) get_post_meta($post_id, '_votes_likes', true);
                        $post_votes++;
                        update_post_meta($post_id, '_votes_likes', $post_votes);
                        $post = get_post($post_id);
                        kibblevote_votes(true);
                        die('');
                endif;

        elseif (isset( $_GET['kibble-vote_dislike'] ) && $_GET['kibble-vote_dislike']>0) :

                $post_id = (int) $_GET['kibble-vote_dislike'];
                $the_post = get_post($post_id);

                if ($the_post && !in_array( $post_id, $vote_count )) :
                        $vote_count[] = $post_id;
                        update_user_meta(get_current_user_id(), 'vote_count', $vote_count);
                        $post_votes = (int) get_post_meta($post_id, '_votes_dislikes', true);
                        $post_votes++;
                        update_post_meta($post_id, '_votes_dislikes', $post_votes);
                        $post = get_post($post_id);
                        kibblevote_votes(true);
                        die('');

                endif;

        endif;

    } elseif (!is_user_logged_in() ) {

        $vote_count = '';

        if(isset($_COOKIE['vote_count'])){
            $vote_count = @unserialize(base64_decode($_COOKIE['vote_count']));
        }

        if(!is_array($vote_count) && isset($vote_count)){
            $vote_count = array();
        }

        if (isset( $_GET['kibble-vote_like'] ) && $_GET['kibble-vote_like']>0) :

                $post_id = (int) $_GET['kibble-vote_like'];
                $the_post = get_post($post_id);

                if ($the_post && !in_array( $post_id, $vote_count )) :
                        $vote_count[] = $post_id;
                        $_COOKIE['vote_count']  = base64_encode(serialize($vote_count));
                        setcookie('vote_count', $_COOKIE['vote_count'] , time()+(10*365*24*60*60),'/');
                        $post_votes = (int) get_post_meta($post_id, '_votes_likes', true);
                        $post_votes++;
                        update_post_meta($post_id, '_votes_likes', $post_votes);
                        $post = get_post($post_id);
                        kibblevote_votes(true);
                        die('');
                endif;

        elseif (isset( $_GET['kibble-vote_dislike'] ) && $_GET['kibble-vote_dislike']>0) :

                $post_id = (int) $_GET['kibble-vote_dislike'];
                $the_post = get_post($post_id);

                if ($the_post && !in_array( $post_id, $vote_count )) :
                        $vote_count[] = $post_id;
                        $_COOKIE['vote_count']  = base64_encode(serialize($vote_count));
                        setcookie('vote_count', $_COOKIE['vote_count'] , time()+(10*365*24*60*60),'/');
                        $post_votes = (int) get_post_meta($post_id, '_votes_dislikes', true);
                        $post_votes++;
                        update_post_meta($post_id, '_votes_dislikes', $post_votes);
                        $post = get_post($post_id);
                        kibblevote_votes(true);
                        die('');

                endif;

        endif;

    }

}

add_action('init', 'kibblevote_vote');

function reset_all_votes_func(){
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = %d WHERE meta_key = %s", 0, '_votes_likes' ) );
	$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = %d WHERE meta_key = %s", 0, '_votes_dislikes' ) );
	$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->usermeta WHERE meta_key = %s", 'vote_count' ) );
}

