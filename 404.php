<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage kibble
 */

get_header(); ?>

	
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-lg-12">
					<div class="text-center col-sm-12 col-lg-12">
						<h1 class="error-title">Oops, 404!</h1>
						<p class="lead">
							The page you were looking for could not be found, maybe try searching for something?
						</p>
						<!-- search form -->
						<?php get_search_form();?>
					</div>
				</div>
			</div>
		</div>


<div class="clear"></div>

</div>

<?php get_footer(); ?>


