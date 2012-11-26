<?php
if ( is_active_sidebar( 'home-widget-area' ) ) : ?>

		<div id="home-widget-area" class="widget-area">
			<ul class="xoxo">
				<?php dynamic_sidebar( 'home-widget-area' ); ?>
			</ul>
		</div><!-- #home .widget-area -->
		
<?php endif; ?>
		

