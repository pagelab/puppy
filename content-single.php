<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title text-center"><?php the_title(); ?></h1>
    </header>

    <div class="entry-meta text-center">
            <i class="fa fa-calendar"></i>
            <?php kibble_entry_meta();?>
            <span class="sep"> | </span>

            <?php
            $categories_list = get_the_category_list( __( ', ', 'kibble' ) );
            if ( $categories_list ) :
                ?>
                <span class="cat-links">
                    <i class="fa fa-folder-open"></i>
                    <?php printf( __( '%1$s', 'kibble' ), $categories_list ); ?>
                </span>
            <?php endif; ?>

        <?php
        $tag_list = get_the_tag_list( '', __( ', ', 'kibble' ) );

        if ( '' != $tag_list ) {
            echo '<span class="sep"> | </span>';
            printf( '<i class="fa fa-tags"></i> %s', $tag_list );
        }
        ?>
            <span class="sep"> | </span>
	    <?php printf('<i class="fa fa-bar-chart-o"></i> %1$s', kibble_post_views());?>
            <span class="sep"> | </span>
	    <?php printf('<i class="fa fa-link"></i> <a href="%1$s" rel="bookmark">permalink</a>', get_permalink());?>

    </div>

    <div class="entry-content">
	<?php echo kibblevote_votes();?>
        <?php kibble_entry_content(); ?>
        <?php the_content(); ?>
    </div>

</article>

<?php //comments_template();?>
