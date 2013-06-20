<?php
/**
 * Template Name: Home Page 
 *
 *
 * @package sedona
 * @since sedona 1.0
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
	<div class="mobileSplash mobStart">
		<img src="<?php bloginfo('template_directory'); ?>/img/inspired-sm.png" />
		<?php bones_main_nav(); // Adjust using Menus in Wordpress Admin ?>
	</div>

	<?php the_content(); ?>

	<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
