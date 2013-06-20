<?php
/*
Template Name: Slider
*/
?>

<?php get_header(); ?>
			
			<div id="content">
            
            	<?php get_sidebar(); // sidebar 1 ?>
			
				<div class="span10">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php get_template_part( 'content', 'slider' ); ?>
					
							<?php the_content(); ?>
					
					<?php endwhile; ?>	
					
					<?php else : ?>
					
					<article id="post-not-found">
					    <header>
					    	<h1><?php _e("Not Found", "bonestheme"); ?></h1>
					    </header>
					    <section class="post_content">
					    	<p><?php _e("Sorry, but the requested resource was not found on this site.", "bonestheme"); ?></p>
					    </section>
					    <footer>
					    </footer>
					</article>
					
					<?php endif; ?>
			
				</div> 
    
			</div> <!-- end #content -->

<?php get_footer(); ?>
