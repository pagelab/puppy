<?php

function wp_ajax_load_posts(){

	if(!wp_verify_nonce( $_GET['_wpnonce'], 'nonce-ajax-dropdown'))
		die( 'Go away!' );

	$year = isset($_GET['year']) ? $_GET['year'] : '';
	$month = isset($_GET['month']) ? $_GET['month'] : '';

	$args = array(
		'year' => trim($year),
		'monthnum' => trim($month),
		'posts_per_page' => -1,
		'orderby' => 'date',
		'cat' => trim($_GET['cat'] != "-1") ? trim($_GET['cat']) : 0,
	);

	$ajaxsort = new WP_Query($args);
?>
    <div class="row">
      <div class="col-md-12">
	    <?php if ($ajaxsort->have_posts()) : ?>
		<?php while ($ajaxsort->have_posts()) : $ajaxsort->the_post();?>
        		<div class="col-lg-2">
            			<div class="panel">
                			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail();?></a>
            			</div>
        		</div>
	    <?php endwhile;?>

		<?php else:
	        	echo '<div align="center">Nothing Found!</div>';
	        endif; 
	    ?>
	</div>
	</div>
	</div>
<?php
    	exit;
}

add_action('wp_ajax_load_posts', 'wp_ajax_load_posts');
add_action('wp_ajax_nopriv_load_posts', 'wp_ajax_load_posts');

