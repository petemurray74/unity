<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>

	<?php if ( is_front_page() ) : ?>
		<title><?php bloginfo( 'name' ); ?> | <?php bloginfo( 'description' ); ?></title>
	<?php else : ?>
		<title><?php bloginfo( 'name' );?> | <?php wp_title($sep = '' ); ?></title>
	<?php endif; ?>

	<!-- Basic Meta Data -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta charset="utf-8" />
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico" />
	
	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
		
	
	<?php wp_head(); ?>
	
	<!-- Theme style -->
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

	
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="row">
	<div class="twelve columns">
		<div id="header">
			<div id="brand">
				<div class="row">
					<div class="eight columns">
						<div id="blog-title">
						<?php bloginfo( 'name' ); ?>
						</div>
						<div id="blog-description" >
						<h2><?php bloginfo( 'description' ); ?></h2>
						</div>
					</div>	
				</div>
				<div class="row"><div class="twelve columns gap"></div></div>
			</div><!--end brand-->	
			<div class="row">
				<div id="access" class="twelve columns"> <!-- navigation --->
					<?php
						wp_nav_menu( array( 
						'theme_location' => 'primary',
						'menu_class' => 'nav-bar',
						'walker' => new description_walker()
						) );
					?>					
				</div>	
			</div>	
		</div><!--end header-->
		<div class="row"><div class="twelve columns gap"></div></div>
		<div id="main">