<?php

// @version 1.6.4

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<div class="row small-collapse">
	
	<div class="small-12 columns">

		<div class="site-content">
			<?php 
			// test
			echo('Britta custom templae'); ?>

			<?php do_action( 'woocommerce_before_main_content' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'single-product' ); ?>

					<?php 
					// ATTEMPT TO ADD GALLERY 1ST IMAGE
					global $product;
					$attachment_ids = $product->get_gallery_attachment_ids();

					echo '<div class="flexslider"><ul class="slides">';
					foreach( $attachment_ids as $attachment_id ) 
					{
						echo '<li>';
						echo "<img src=".$image_link = wp_get_attachment_url( $attachment_id, 'large').">";
						echo '<p>';
						$attachment_meta = wp_get_attachment($attachment_id);
						echo $attachment_meta['caption'];
						echo '</p>';
						echo '</li>';
					}
					echo '</ul></div>';
					// ATTEMPT END
					?>

				<?php endwhile; // end of the loop. ?>

			<?php do_action( 'woocommerce_after_main_content' ); ?>

			<?php do_action( 'woocommerce_sidebar' ); ?>

		</div>

	</div>
	
</div>

<?php get_footer( 'shop' );