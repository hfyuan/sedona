	<h1 class="pageTitle"><?php the_title(); ?></h1>
		<?php the_content(); ?>
          <!-- Carousel nav -->
          <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
          <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>


		<div id="myCarousel" class="carousel slide">
<!-- Carousel items -->
      <div class="carousel-inner">
            <div class="active item">
                    <img src="<?php echo get_post_meta($post->ID, "image", true); ?>">
                    <div class="gallery-caption"><?php echo get_post_meta($post->ID, 'caption', true); ?></div>
            </div>

            <?php if( get_post_meta($post->ID, 'image2', true) )  { ?>
            <div class="item">
                    <img src="<?php echo get_post_meta($post->ID, "image2", true); ?>" />
                    <div class="gallery-caption"><?php echo get_post_meta($post->ID, 'caption2', true); ?></div>
            </div>
            <?php } ?>
           
            <?php if( get_post_meta($post->ID, 'image3', true) ) { ?>
            <div class="item">
                    <img src="<?php echo get_post_meta($post->ID, "image3", true); ?>" />
                    <div class="gallery-caption"><?php echo get_post_meta($post->ID, 'caption3', true); ?></div>
            </div>
            <?php } ?>
       
            <?php if( get_post_meta($post->ID, 'image4', true) ) { ?>
            <div class="item">
                    <img src="<?php echo get_post_meta($post->ID, "image4", true); ?>" />
                    <div class="gallery-caption"><?php echo get_post_meta($post->ID, 'caption4', true); ?></div>
            </div>
            <?php } ?>

            <?php if( get_post_meta($post->ID, 'image5', true) ) { ?>
            <div class="item">
                    <img src="<?php echo get_post_meta($post->ID, "image5", true); ?>" />
                    <div class="gallery-caption"><?php echo get_post_meta($post->ID, 'caption5', true); ?></div>
            </div>
            <?php } ?>

            <?php if( get_post_meta($post->ID, 'image6', true) ) { ?>
            <div class="item">
                    <img src="<?php echo get_post_meta($post->ID, "image6", true); ?>" />
                    <div class="gallery-caption"><?php echo get_post_meta($post->ID, 'caption6', true); ?></div>
            </div>
            <?php } ?>

            <?php if( get_post_meta($post->ID, 'image7', true) ) { ?>
            <div class="item">
                    <img src="<?php echo get_post_meta($post->ID, "image7", true); ?>" />
                    <div class="gallery-caption"><?php echo get_post_meta($post->ID, 'caption7', true); ?></div>
            </div>
            <?php } ?>
		</div>



		</div>

        <section id="orange">
        <ul>
<?php if( is_page('292') ) : ?>
            <li><a href="index.php?p=294" id="just-the-facts" class="button">Amenities Gallery</a></li>
            <li><a href="index.php?p=296" id="just-the-facts" class="button">Neighborhood Gallery</a></li>
<?php elseif( is_page('294') ) : ?>
            <li><a href="index.php?p=296" id="just-the-facts" class="button">Neighborhood Gallery</a></li>
            <li><a href="index.php?p=292" id="just-the-facts" class="button">Residences Gallery</a></li>
<?php elseif( is_page('296') ) : ?>
            <li><a href="index.php?p=294" id="just-the-facts" class="button">Amenities Gallery</a></li>
            <li><a href="index.php?p=292" id="just-the-facts" class="button">Residences Gallery</a></li>
<?php else : ?>
<?php endif; ?>
            <li><a href="<?php echo home_url(); ?>/gallery" id="just-the-facts" class="button">Back to Gallery</a></li>
        </ul>
    </section>
