<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title text-center"><a href="<?php echo get_permalink($post->post_parent);?>"><?php echo get_the_title($post->post_parent); ?></a></h1>
    </header>

    <div class="entry-meta text-center">
            <i class="fa fa-calendar"></i>

		<?php kibble_attachment_meta();?>

            <span class="sep"> | </span>

            <?php
            $categories_list = get_the_category_list( ', ', '', $post->post_parent );
            if ( $categories_list ) :
                ?>
                <span class="cat-links">
                    <i class="fa fa-folder-open"></i>
                    <?php printf( __( '%1$s', 'kibble' ), $categories_list ); ?>
                </span>

        <?php
        $tag_list = get_the_term_list( $post->post_parent, 'post_tag','',', ');

        if ( $tag_list ) {
            echo '<span class="sep"> | </span>';
            printf( '<i class="fa fa-tags"></i> %s', $tag_list );
        }

      ?>
            <span class="sep"> | </span>
	    <?php printf('<i class="fa fa-bar-chart-o"></i> %1$s', kibble_post_views());?>

           <span class="sep"> | </span>

		<?php printf('<i class="fa fa-link"></i> <a href="%1$s" rel="bookmark">permalink</a>', get_permalink($post->post_parent));?>

            <?php endif; ?>

<br/>
<br/>
<nav role="navigation" id="image-navigation" class="navigation-image nav-links">
	<div class="nav-previous"><?php previous_image_link( false, __( '<i class="fa fa-chevron-left"></i> Previous', 'unite' ) ); ?></div>
	<div class="nav-next"><?php next_image_link( false, __( 'Next <i class="fa fa-chevron-right"></i>', 'unite' ) ); ?></div>
</nav>

<div class="clearfix"></div>

<div class="entry-attachment">
<div class="attachment">

<?php
$attachments = array_values( get_children( array(
	'post_parent'    => $post->post_parent,
	'post_status'    => 'inherit',
	'post_type'      => 'attachment',
	'post_mime_type' => 'image',
	'order'          => 'ASC',
	'orderby'        => 'menu_order ID'
) ) );

foreach ( $attachments as $k => $attachment ) {
	if ( $attachment->ID == $post->ID )
	break;
}

$k++;

if ( count( $attachments ) > 1 ) {
	if ( isset( $attachments[ $k ] ) )
		$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
	else
		$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
} else {
		$next_attachment_url = wp_get_attachment_url();
}

$custom_class = array('class' => 'thumbnail img-responsive');
?>

<a href="<?php echo $next_attachment_url; ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php echo wp_get_attachment_image( $post->ID, 'full' , false, $custom_class);?></a>

<nav role="navigation" id="image-navigation" class="navigation-image nav-links">
	<div class="nav-previous"><?php previous_image_link( false, __( '<i class="fa fa-chevron-left"></i> Previous', 'unite' ) ); ?></div>
	<div class="nav-next"><?php next_image_link( false, __( 'Next <i class="fa fa-chevron-right"></i>', 'unite' ) ); ?></div>
</nav>

</div>

</div>

</article>




