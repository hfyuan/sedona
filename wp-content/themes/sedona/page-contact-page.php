<?php
/*
Template Name: Contact Page
*/
?>

<?php get_header(); ?>
			
			<div id="content">
            
            	<?php get_sidebar(); // sidebar 1 ?>
			
				<div class="span8 contact">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php echo get_post_meta($post->ID, 'hero_dataset', true); ?>

				<?php the_content(); ?>
					
					<?php endwhile; ?>	
					
					<?php endif; ?>
			
				</div> 
    
			</div> <!-- end #content -->

<?php get_footer(); ?>
