<?php
/**
 * The template for displaying Tag pages.
 *
 * @package WordPress
 * @subpackage kibble
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<?php $mytags = get_query_var('tag');?>
		<?php $mytags = str_replace('+',' and ', $mytags);?>
		<?php $mytags = str_replace(',',' or ', $mytags);?>

		<div class="col-md-12">

			<h2 class="page-header text-center">Tag Archives for: <?php echo $mytags;?></h2>

		</div>

		<?php while ( have_posts() ) : the_post(); ?>

      			<div class="col-lg-2">
       				<div class="panel">
               				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail();?></a>
      				</div>
       			</div>

			<?php endwhile; ?>

	<?php endif; ?>

</div>

<?php kibble_paging();?>

<?php get_footer(); ?>

