<?php get_header(); ?>
	<div id="content" class="row paddout">
		<div class="eight columns">	

			<?php  if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php the_date('','<p class="date_over">','</p>'); ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>
		</div>
		<div id="sidebar" class="four columns">									
			<?php get_sidebar(); // default sidebar  ?>
			
		</div>	
	</div><!-- #content -->
<?php get_footer(); ?>