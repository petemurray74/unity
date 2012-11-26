<?php
/*
Template Name: Homepage
*/
?>

<?php get_header(); ?>
	<div id="content" class="row">
		<div class="twelve columns">	
			<?php  if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

			
			
		</div>
	</div><!-- #content -->
	<div class="row"><div class="twelve columns gap"><hr /></div></div>
	<div id="home-sidebar" class="row">									
			<?php get_sidebar('home'); // home sidebar  ?>
	</div>	

<?php get_footer(); ?>