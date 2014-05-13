<?php

/**
 * Add theme options
 *
*/
require( get_template_directory() . '/lib/options.class.php' );

/**
 * Updater class for wp-updates.com
 *
*/

require( get_template_directory() . '/lib/wp-updates-theme.php' );

/**
 * Hook into the updater
 *
*/

new WPUpdatesThemeUpdater( 'http://wp-updates.com/api/1/theme', 733, basename(get_template_directory()) );

/**
 * define our video width and height from theme options panel
 *
*/

DEFINE('AVO_WIDTH', kibble_option('kibble_video_width'));
DEFINE('AVO_HEIGHT', kibble_option('kibble_video_height'));

/**
 * Enable custom oembed codes
 *
*/
require( get_template_directory() . '/lib/oembed.php' );

/**
 * Various theme functions like pagination, post meta, attachment meta
 *
*/
require( get_template_directory() . '/lib/theme-functions.php' );

/**
 * Various image functions (custom html for thumbnails, gallery shortcode)
 *
*/

require( get_template_directory() . '/lib/image-functions.php' );

/**
 * Require a thumbnail before publish
 *
*/

require( get_template_directory() . '/lib/require-thumbnail.php' );

/**
 * Enable Category images
 *
*/

require( get_template_directory() . '/lib/category-images.php' );


/**
 * Our custom queries for different pages on the site
 *
*/

require( get_template_directory() . '/lib/custom-query.php' );

/**
 * Enable minimal menu without any extra markeup
 *
*/

require( get_template_directory() . '/lib/nav-walker.php' );

/**
 * Post Video Embed
 *
*/

require( get_template_directory() . '/lib/video-box.php' );

/**
 * Post Voting
 *
*/

require( get_template_directory() . '/lib/voting.php' );

/**
 * Custom rewrite for media attachments, and search urls
 *
*/

require( get_template_directory() . '/lib/custom-rewrite.php' );

/**
 * Enqueue styles and javascripts
 *
*/

require( get_template_directory() . '/lib/scripts.php' );

/**
 * Register Menus, and post thumbnail support
 *
*/

require( get_template_directory() . '/lib/theme-setup.php' );

/**
 * Remove header junk
 *
*/

require( get_template_directory() . '/lib/remove-junk.php' );

/**
 * Trim css nav menu output
 *
*/
require( get_template_directory() . '/lib/trim-menus.php' );

/**
 * Archives via Ajax
 *
*/
require( get_template_directory() . '/lib/ajax-archives.php' );

/**
 * Create Archives and Category Index page on theme activate
 *
*/

require( get_template_directory() . '/lib/create-pages.php' );

/**
 * Create Menu automatically populated with pages, and category children
 *
*/

require( get_template_directory() . '/lib/create-menu.php' );
