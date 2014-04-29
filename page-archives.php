<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
	<div class="row">
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">×</button>
		Here you can view our archives by date and/or category, it loads via ajax so no reloading!
        </div>
	</div>
	<div class="clear" style="height:4px;clear:both;"></div>

	<div id="archive-browser">

	<div class="col-xs-12 col-sm-6 col-md-6">
              <select id="month-choice" name="" class="selectpicker form-control">
                <option value="no-choice" selected> &mdash; </option>
		<?php wp_get_archives(array('type' => 'monthly', 'format'  => 'option')); ?>
              </select>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6">
		<?php wp_dropdown_categories('hide_empty=0&show_option_none= -- ');?> 
	</div>
	</div>
	</div>

	<div class="clear" style="height:14px;clear:both;"></div>

	<div id="archive-wrapper" align="center">

		<div class="message" align="center">Please choose from above.</div>

		<div id="archive-content"></div>
	</div>

     </div>
</div>

<?php get_footer(); ?>
