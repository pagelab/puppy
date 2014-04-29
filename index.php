<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage kibble
 */

get_header(); ?>

<?php if(is_home() && !is_paged()):?>
<div class="col-md-12">
    <h2 class="page-header text-center"><strong>Random Submissions</strong></h2>
</div>

    <?php $args = array('posts_per_page' => 6, 'orderby' => 'rand');?>
    <?php $random_home = new WP_query($args); ?>
    <?php while ($random_home->have_posts()) : $random_home->the_post(); ?>

        <div class="col-lg-2">
            <div class="panel">
                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail();?></a>
            </div>
        </div>

    <?php endwhile;?>
    <?php endif;?>

<?php if ( have_posts() ) : ?>

            <h2 class="page-header text-center"><strong>Recent Submissions</strong></h2>

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
