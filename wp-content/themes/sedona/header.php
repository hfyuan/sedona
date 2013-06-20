<!doctype html>  

<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="ie.css" />
<![endif]-->
	
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<title>
			<?php if ( !is_front_page() ) { echo wp_title( ' ', true, 'left' ); echo ' | '; }
			echo bloginfo( 'name' ); echo ' - '; bloginfo( 'description', 'display' );  ?> 
		</title>
				
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- icons & favicons -->
		<!-- For iPhone 4 -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/library/images/icons/h/apple-touch-icon.png">
		<!-- For iPad 1-->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/library/images/icons/m/apple-touch-icon.png">
		<!-- For iPhone 3G, iPod Touch and Android -->
		<link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/library/images/icons/l/apple-touch-icon-precomposed.png">
		<!-- For Nokia -->
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/library/images/icons/l/apple-touch-icon.png">
		<!-- For everything else -->
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
				
		<!-- media-queries.js (fallback) -->
		<!--[if lt IE 9]>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>			
		<![endif]-->

		<!-- html5.js -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
  		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<!-- theme options from options panel -->
		<?php //get_wpbs_theme_options(); ?>

	</head>
	
	<body <?php body_class(); ?>>
		<div id= "wrap">

			<?php if( is_page('5') ) : // adds class of mastheadHome (to hide navbar) ?>
			<header role="mastheadHome">

			<?php else : // navbar always showing ?>
			<header role="masthead">

			<?php endif; ?>

				<a id="logo" title="<?php echo get_bloginfo('description'); ?>" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
				
				<nav role="navigation">		
					<div class="navbar">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
						</a>
						
						<div class="nav-collapse">
							<?php bones_main_nav(); // Adjust using Menus in Wordpress Admin ?>
						</div>
                        </div>
				</nav>
				<nav id="switchSite">
					<ul>
						<li class="sedona"><a href="<?php echo network_home_url(); ?>sedona">sedona</a></li>
						<li class="slate"><a href="<?php echo network_home_url(); ?>slate">slate</a></li>
					</ul>
				</nav>
				<nav id="social-media">
				<ul>             
					<li><a href="https://twitter.com/sedonaslate" target="_blank" class="icon-twitter">Twitter</a></li>
					<li><a href="http://www.facebook.com/SedonaSlate/" target="_blank" class="icon-facebook">Facebook</a>
                    <li><a href="http://www.youtube.com/user/SedonaSlate" target="_blank" class="icon-youtube">YouTube</a></li>
				</ul>
				</nav>


				<section id="location">
					<ul>
					<li class="visit">1510 Clarendon Boulevard Arlington, VA 22209</li>
					<li class="visit"><span id="LTSDynamicCampaignText">(999)999-9999</span>
					</li>
					</ul>
				</section>

					

				
			</header> <!-- end header -->
