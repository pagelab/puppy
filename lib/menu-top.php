<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex3-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
		<a class="navbar-brand" href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a>
		</div>

                <div class="collapse navbar-collapse navbar-ex3-collapse">
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'depth'          => 2,
				'container'      => false,
				'menu_class'     => 'nav navbar-nav',
				'walker'         => new wp_bootstrap_navwalker(),
				'fallback_cb'    => 'wp_bootstrap_navwalker::fallback'
				)
			);?>

				<form id="searchform" class="navbar-form navbar-right" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
					<div class="form-group">
						<input id="s" name="s" type="text" class="form-control" placeholder="<?php esc_attr_e( '   Search &hellip;', 'kibble' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
						<button id="searchsubmit" type="submit" class="btn btn-default">Search</button>
					</div>
				</form>
		</div>
	</nav>



