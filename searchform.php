<?php
/**
 * The template for displaying search form
 *
 * @package Kibble
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
    <div class="input-group">
        <input type="text" class="form-control" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'kibble' ); ?>" />

        <span class="input-group-btn">
            <button class="btn btn-primary" id="searchsubmit" type="button"><?php esc_attr_e( 'Search', 'kibble' ); ?></button>
        </span>
    </div><!-- /input-group -->
</form>
