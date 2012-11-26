<?php
/*
Template Name: Homepage 2-col
*/
?>

<?php get_header(); ?>
	<div id="content" class="row">
		<div class="eight columns">	
			<?php  if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

			
			
		</div>
	<!-- #content -->
		<div id="sidebar" class="four columns">								
			<?php get_sidebar('home'); // default sidebar  ?>
		</div>	
	</div>	

<?php get_footer(); ?>