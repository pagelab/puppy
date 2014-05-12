<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage kibble
 */

get_header(); ?>

<div class="col-sm-2">

	<div class="row">
		<div class="col-xs-12">

			<?php $ids = array();?>
			<?php $args = array('posts_per_page' => 3, 'orderby' => 'rand');?>
			<?php $random_post = new WP_query($args); ?>
			<?php while ($random_post->have_posts()) : $random_post->the_post(); ?>
				<?php $ids[] = $post->ID;?>
				<div class="post"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail();?></a></div>
			<?php endwhile;?>
			<?php //wp_reset_postdata();?>

		</div>
	</div>
</div>

<div class="col-sm-8">

	<div class="row">
		<div class="col-xs-12">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $ids[] = $post->ID;?>
				<?php get_template_part( 'content', 'image' ); ?>
			<?php endwhile; ?>
		</div>
	</div>
</div>

<div class="col-sm-2">
	<div class="row">
		<div class="col-xs-12">

			<?php $ids = array();?>
			<?php $args = array('posts_per_page' => 3, 'orderby' => 'rand');?>
			<?php $random_post = new WP_query($args); ?>
			<?php while ($random_post->have_posts()) : $random_post->the_post(); ?>
				<?php $ids[] = $post->ID;?>
				<div class="post"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail();?></a></div>
			<?php endwhile;?>
			<?php //wp_reset_postdata();?>

		</div>
	</div>

<hr/>

</div>

</div>

</div>

<hr/>

<div class="container">
	<div class="row">

		<?php $args = array('posts_per_page' => 6, 'orderby' => 'rand', 'post__not_in' => $ids);?>
		<?php $random_bottom = new WP_query($args); ?>
		<?php while ($random_bottom->have_posts()) : $random_bottom->the_post(); ?>
			<?php if (!in_array($post->ID, $ids)) : ?>
				<div class="col-sm-2">
					<div class="row">
						<div class="col-xs-12">
							<div class="post"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail();?></a></div>
						</div>
					</div>
				</div>
			<?php endif; endwhile;?>
			<?php wp_reset_postdata();?>

		</div>
	</div>

<?php get_footer(); ?>
