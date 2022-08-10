<?php get_header(); ?>

	<?php
		if( !is_front_page() ) {
		?>
		<div class="row small-collapse">
			<div class="small-12 columns">
		<?php
		}
	?>

		<div class="site-page-content">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content/content', 'page' );

			endwhile; // End of the loop.
			?>

		</div>

	<?php
		if( !is_front_page() ) {
		?>
			</div>
		</div>
		<?php
		}
	?>


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