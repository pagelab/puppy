<?php
/**
 * The template for displaying Archive pages.
 *
 * @package WordPress
 * @subpackage kibble
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<div class="col-md-12">

			<h2 class="page-header text-center"><?php if ( is_day() ) :
					printf( __( 'Daily Archives: %s', 'kibble' ), get_the_date() );
				elseif ( is_month() ) :
					printf( __( 'Monthly Archives: %s', 'kibble' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'kibble' ) ) );
				elseif ( is_year() ) :
					printf( __( 'Yearly Archives: %s', 'kibble' ), get_the_date( _x( 'Y', 'yearly archives date format', 'kibble' ) ) );
				else :
					_e( 'Archives', 'kibble' );
				endif;?></h2>

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

