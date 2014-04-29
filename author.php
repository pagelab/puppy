<?php
/**
 * The template for displaying Author pages.
 *
 * @package WordPress
 * @subpackage kibble
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<div class="col-md-12">

			<h2 class="page-header text-center"><?php printf( __( 'All posts by %s', 'kibble' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h2>
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

