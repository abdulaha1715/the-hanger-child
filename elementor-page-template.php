<?php 

/* 
	Template Name: Elementor Page
 */

get_header();

?>

	<div class="elementor-content">
		<div class="large-12">
			
			<?php
				while ( have_posts() ) : the_post();
			?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content">
						<?php
							the_content();

							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'the-hanger' ),
								'after'  => '</div>',
							) );
						?>
					</div><!-- .entry-content -->
					
				</article><!-- #post-## -->
			<?php
				endwhile; // End of the loop.
			?>

		</div>
	</div>

<?php
get_footer();