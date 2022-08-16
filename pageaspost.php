<?php /* Template Name: Page As Post */ ?>

<?php get_header();?>

	<div class="row small-collapse">
		<div class="small-12 columns">

			<div class="site-content">
				<div class="row">
					<div class="large-8 columns">
						<div class="page_as_post_header">
								<?php
								/* code found online. I don't get the output on the pages. Html seems messy?*/

									if ( function_exists('yoast_breadcrumb') ) {

										yoast_breadcrumb( '<p id=breadcrumbs>','</p>' );

									}

								?>

							<?php 
								//place title here if you want it as on blog page, wider than content area.
								//the_title( '<h1 class="entry-title">', '</h1>' ); 
							?>
						</div>
					</div>
				</div>
				<div class="row">

					<div class="large-8 columns large-offset-2">
						
						<?php
							while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content/content', 'page' );

							endwhile; // End of the loop.
						?>
					</div>
				</div>

			</div>

		</div>
	</div>

	<?php if ( comments_open() || get_comments_number() ) : ?>
	<div class="single-comments-container">
		<div class="row">
			<div class="large-8 columns large-offset-2">
				<?php comments_template(); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

<?php
//get_sidebar();
get_footer();