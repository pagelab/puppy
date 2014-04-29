<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage kibble
 */

get_header(); ?>

<div class="col-sm-12">

	<div class="row">
		<div class="col-xs-12">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $ids[] = $post->ID;?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; ?>
		</div>
	</div>
</div>

<hr/>

</div>

</div>

</div>

<hr/>

	</div>

<?php get_footer(); ?>
