<?php

/**
 * Post Meta information
 *
*/

function kibble_entry_meta() {
    printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"></span>', 'kibble' ),
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', 'kibble' ), get_the_author() ) ),
        esc_html( get_the_author() )
    );
}

/**
 * Attachment Meta Information
 *
*/

function kibble_attachment_meta() {
	global $post;

	$post_title = get_the_title( $post->post_parent );
    	printf( __( '<time class="entry-date" datetime="%1$s" pubdate>%2$s</time><span class="byline"></span>', 'kibble' ),
        	esc_attr( get_the_time() ),
       		esc_html( get_the_date() )
    	);
}

/**
 * Pagination with 1,2,3,4 links
 *
*/

function kibble_paging($before = '', $after = '') {
	global $wpdb, $wp_query;

	if ( !is_single() && $wp_query->max_num_pages > 1 ) {

	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
		
	echo $before.'<div class="col-sm-12 text-center"><ul class="pagination">'."";
	if ($paged > 1) {
		$first_page_text = "«";
		echo '<li class="prev"><a href="'.get_pagenum_link().'" title="First">'.$first_page_text.'</a></li>';
	}
		
	$prevposts = get_previous_posts_link('← Previous');
	if($prevposts) { echo '<li>' . $prevposts  . '</li>'; }
	else { echo '<li class="disabled"><a href="#">← Previous</a></li>'; }
	
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="active"><a href="#">'.$i.'</a></li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="">';
	next_posts_link('Next →');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = "»";
		echo '<li class="next"><a href="'.get_pagenum_link($max_page).'" title="Last">'.$last_page_text.'</a></li>';
	}
	echo '</ul></div>'.$after."";
	}
}

/**
 * Custom function for site title
 *
*/
function kibble_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	$title .= get_bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'kibble' ), max( $paged, $page ) );

	return $title;
}

add_filter( 'wp_title', 'kibble_wp_title', 10, 2 );

/**
 * Custom function for gallery, single image, and video rendering
 *
*/

function kibble_entry_content() {

	global $post;

	$video = get_post_meta($post->ID,'_kibble_video',true);

	if ( get_post_meta($post->ID,'_kibble_video',true) ) {
		$url = get_post_meta( $post->ID, '_kibble_video', true );
		?>
		<div align="center">
		<video
			id="video-id"
			width="510"
			height="385"
			class="video-js vjs-flat-skin" 
			controls preload="auto" 
			data-setup='{ "techOrder": ["youtube"], "src": "<?php echo $url;?>" }'>
		</video>
		</div>
<?php	}

	if ( !get_post_gallery() && has_post_thumbnail() && $video == false) {
		echo '<div class="post" align="center">';
		$large = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
		$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
		echo '<a href="'. $large .'"><img title="'. get_the_title($post->ID).'" src="'. $thumb[0] .'" class="img-responsive thumbnail"></a>';
		echo '</div>';
	}
}

/**
 * Custom function for showing category images
 *
*/

function kibble_show_category_images() {

	$terms = get_terms('category', array('hide_empty' => true));

	foreach ( $terms as $term ) {
		$image = kibble_get_taxonomy_image_src($term,'full');
		echo '<div class="col-sm-3">' . PHP_EOL;
		echo '<div class="category thumbnail">' . PHP_EOL;
		echo '<a href="' . esc_url( get_term_link( $term ) ) . '"><img src="' . $image['src'] . '" class="img-responsive" /></a>' . PHP_EOL;
		echo '</div>' . PHP_EOL . PHP_EOL;
		echo '</div>' . PHP_EOL . PHP_EOL;
	}
}

function kibble_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'kibble' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'kibble' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'kibble' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'kibble' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'kibble' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'kibble' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>',
				) ) );
			?>
		</article><!-- .comment-body -->

	<?php
	endif;
}

function kibble_post_views() {
    	$views = floor(lcg_value() * (1500 - 480 + 1) + 480);
    	return $views . ' views';
}
