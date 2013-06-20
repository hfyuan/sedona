<?php
/*
Template Name: Google Map Page
*/
?>

<?php get_header(); ?>
			
			<div id="content">
            
            	<?php get_sidebar(); // sidebar 1 ?>
			
				<div class="span10">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php echo get_post_meta($post->ID, 'hero_dataset', true); ?>

				<?php the_content(); ?>


						<!-- dirs here -->
						    <nav id="orange">
						    	<ul>
							    	<li><a class="button" href="http://www.sedona-slate.com/bin/pub/pdf/Sedona_map.pdf" target="_blank">Download PDF</a></li> 
							    	<li><a class="button" href="http://jbgmetro.com/sedona" target="_blank"> Real time metro schedule</a></li> 
							    	<li><a class="button" href="http://www.walkscore.com/score/1510-clarendon-boulevard-arlington-va-22209" target="_blank">See Our Walkscore</a></li> 
							    	<li><a class="button" href="http://www.carfreediet.com/pages/arlingtons-urban-villages/rosslyn/getting-around/" target="_blank">Commuter Services</a></li>

						    	</ul>
						    </nav>

<!-- Map specific directions (to preserve formatting) -->		
    								<section id="directions"><script src="//www.gmodules.com/ig/ifr?url=http://hosting.gmodules.com/ig/gadgets/file/114281111391296844949/driving-directions.xml&amp;up_fromLocation=&amp;up_myLocations=1510%20CLARENDON%20BOULEVARD%20ARLINGTON%2C%20VA%2022209%20&amp;up_defaultDirectionsType=&amp;up_autoExpand=&amp;synd=open&amp;w=270&amp;h=55&amp;title=Directions+by+Google+Maps&amp;brand=light&amp;lang=en&amp;country=US&amp;border=%23ffffff%7C3px%2C1px+solid+%23999999&amp;output=js"></script>
	</section>
					
					
					<?php endwhile; ?>	
					
					<?php endif; ?>
			
				</div> 
				
			</div> <!-- end #content -->

<?php get_footer(); ?>
