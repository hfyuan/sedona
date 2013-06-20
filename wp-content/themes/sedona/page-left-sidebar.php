<?php
/*
Template Name: Left Sidebar Page
*/
?>

<?php get_header(); ?>
			
	<div id="content">

		<?php get_sidebar(); // sidebar 1 ?>

		<div class="span10">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php endwhile; ?>	
			
			<?php endif; ?>


	<!-- Still Carousel items (to preserve formatting) -->
		<div id="myCarousel" class="carousel slide">
		  <div class="carousel-inner contentSlide">
				<div class="active item"> <!-- spoofs the carousel to preserve formatting -->
					<?php if( get_post_meta($post->ID, 'hero_caption', true) ) { ?>
					<div class="content-caption"><?php echo get_post_meta($post->ID, 'hero_caption', true); ?></div>
					<?php } ?>

					<?php if( get_post_meta($post->ID, 'hero_image', true) ) { ?>
					<img src="<?php echo get_post_meta($post->ID, 'hero_image', true); ?>">
					<?php } ?>
					
					<?php echo get_post_meta($post->ID, 'hero_dataset', true); ?>

					<section id="grabcontent">
					<?php the_content(); ?>
					</section>
				</div> <!-- spoofs the carousel to preserve formatting -->
			</div>
		</div> 
	<!-- Still Carousel items (to preserve formatting) -->

	</div> <!-- end #content -->
	</div> <!-- end #content -->

<?php get_footer(); ?>
