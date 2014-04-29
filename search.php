<?php
/**
 * The template for displaying Search pages.
 *
 * @package WordPress
 * @subpackage kibble
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<div class="col-md-12">
			<h2 class="page-header text-center"><?php printf( __( 'Search Results for: %s', 'kibble' ), get_search_query() ); ?></h2>
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

