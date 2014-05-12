<?php

/**
 * Get image url from taxonomy
 *
*/

function kibble_get_taxonomy_image_src( $tax_term, $size = 'thumbnail' ) {
    if ( ! is_object( $tax_term ) ) return false;
    $src = get_option( 'kibble_tax_image_' . $tax_term->taxonomy . '_' . $tax_term->term_id );
    $tmp = false;
    if ( is_numeric( $src ) ) {
        $tmp = wp_get_attachment_image_src( $src, $size );
        if ( $tmp && ! is_wp_error( $tmp ) && is_array( $tmp ) && count( $tmp ) >= 3 )
            $tmp = array( 'ID' => $src, 'src' => $tmp[0], 'width' => $tmp[1], 'height' => $tmp[2] );
        else
            return false;
    } elseif ( ! empty( $src ) ) {
        $tmp = array( 'src' => $src );
    }
    if ( $tmp && ! is_wp_error( $tmp ) && is_array( $tmp ) && isset( $tmp['src'] ) )
        return $tmp;
    else
        return false;
}

/**
 * Get taxonomy image with html 
 *
*/

function kibble_get_taxonomy_image( $tax_term, $size = 'thumbnail' ) {
    $image = kibble_get_taxonomy_image_src( $tax_term, $size );
    if ( ! $image ) return false;
    return '<img src="' . $image['src'] . '" alt="' . $tax_term->name . '" class="taxonomy-term-image" width="' . ( ( $image['width'] ) ? $image['width'] : '' ) . '" height="' . ( ( $image['height'] ) ? $image['height'] : '' ) . '" />';
}

function kibble_taxonomy_image( $tax_term, $size = 'thumbnail' ) {
    $img = kibble_get_taxonomy_image( $tax_term, $size );
    if ( $img ) echo $img;
}

add_action( 'admin_head', 'kibble_init' );
add_action( 'edit_term', 'kibble_save_fields' , 10, 3 );
add_action( 'create_term', 'kibble_save_fields' , 10, 3 );

/**
 * Add the create and edit columns for category images
 *
*/

function kibble_init() {
    $taxes = get_taxonomies();
    if ( is_array( $taxes ) ) {
        foreach ( $taxes as $tax ) {
            add_action( $tax . '_add_form_fields', 'kibble_add_fields' );
            add_action( $tax . '_edit_form_fields', 'kibble_edit_fields' );
            add_filter( "manage_edit-{$tax}_columns", 'kibble_add_taxonomy_column' );
            add_filter( "manage_{$tax}_custom_column", 'kibble_edit_taxonomy_columns' , 10, 3 );
        }
    }
}

/**
 * Add an image for a category
 *
*/

function kibble_add_fields() {
    global $wp_version;
    kibble_setup_field_scripts();
	?>
    <div class="form-field" style="overflow: hidden;">
        <label><?php _e( 'Image' ); ?></label>
        <input type="hidden" name="kibble_tax_image" id="kibble_tax_image" value="" />
        <input type="hidden" name="kibble_tax_image_classes" id="kibble_tax_image_classes" value="" />
        <br/>
        <img src="" id="kibble_tax_image_preview" style="max-width:300px;max-height:300px;float:left;display:none;padding:0 10px 5px 0;" />
        <a href="#" class="<?php echo 'button'; ?>" id="kibble_tax_add_image"><?php _e( 'Add/Change Image' ); ?></a>
        <a href="#" class="<?php echo 'button'; ?>" id="kibble_tax_remove_image" style="display: none;"><?php _e( 'Remove Image' ); ?></a>
    </div>
    <?php
}

/**
 * Edit an image for a category
 *
*/

function kibble_edit_fields( $taxonomy ) {
    kibble_setup_field_scripts();?>
    <tr class="form-field">
        <th><label for="kibble_tax_image"><?php _e( 'Image' ); ?></label></th>
        <td>
            <?php $image = kibble_get_taxonomy_image_src($taxonomy, 'full'); ?>
            <input type="hidden" name="kibble_tax_image" id="kibble_tax_image" value="<?php echo ($image)?$image['src']:''; ?>" />
            <input type="hidden" name="kibble_tax_image_classes" id="kibble_tax_image_classes" value="" />
            <?php $image = kibble_get_taxonomy_image_src($taxonomy);  ?>
            <img src="<?php echo ($image)?$image['src']:''; ?>" id="kibble_tax_image_preview" style="max-width: 300px;max-height: 300px;float:left;display: <?php echo($image['src'])?'block':'none'; ?>;padding: 0 10px 5px 0;" />
            <a href="#" class="button" id="kibble_tax_add_image" style=""><?php _e( 'Add/Change Image' ); ?></a>
            <a href="#" class="button" id="kibble_tax_remove_image" style="display: <?php echo ( $image['src'] ) ? 'inline-block' : 'none'; ?>;"><?php _e( 'Remove Image' ); ?></a>
        </td>
    </tr>
    <?php
}

/**
 * Enqueue media and backbone code for media manager 
 *
*/

function kibble_setup_field_scripts() {
       wp_enqueue_media();
       wp_enqueue_script( 'kibble-taxonomy-images', get_template_directory_uri() . '/js/kibble.js', array( 'jquery' ) );
}

/**
 * Save image for a category
 *
*/

function kibble_save_fields($term_id, $tt_id = null, $taxonomy = null) {
    $kibble_option = "kibble_tax_image_{$taxonomy}_{$term_id}";
    if ( isset( $_POST['kibble_tax_image'] ) && ( $src = $_POST['kibble_tax_image'] ) ) {
        if ( $src != '' ) {
            if ( isset( $_POST['kibble_tax_image_classes'] ) && preg_match( '/wp-image-([0-9]{1,99})/', $_POST['kibble_tax_image_classes'], $matches ) ) {
                update_option( $kibble_option, $matches[1] );
            } else {
                global $wpdb;
                $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid='%s';", $src) );
                if ( 0 < absint( $attachment[0] ) )
                    update_option( $kibble_option, $attachment[0] );
                else
                    update_option( $kibble_option, $src );
            }
        }
        else {
            $test = get_option( $kibble_option );
            if ( $test )
                delete_option( $kibble_option );
        }
    }
    else {
        $test = get_option( $kibble_option );
        if ( $test )
            delete_option( $kibble_option );
    }
}

/**
 * Add taxonomy image column to term pages
 *
*/
function kibble_add_taxonomy_column( $columns ) {
     $columns['kibble_tax_image_thumb'] = 'Taxonomy Image';
     return $columns;
}

/**
 * Add edit taxonomy image column to term pages
 *
*/

function kibble_edit_taxonomy_columns( $out, $column_name, $term_id ) {
     if ( $column_name != 'kibble_tax_image_thumb' ) return $out;
     $term = get_term( $term_id, $_GET['taxonomy'] );
     $image = kibble_get_taxonomy_image( $term, array( 50, 50 ) );
     if ( $image ) $out = $image;
     return $out;
}

