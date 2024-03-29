<!DOCTYPE html>

<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div class="site-wrapper">

		<div class="hover_overlay_body"></div>

		<?php if (get_post_meta( getbowtied_page_id(), 'header_meta_box_check', true ) != 'off'): ?>

			<?php if ( 1 == GBT_Opt::getOption('topbar_toggle') ) : ?>
				<?php get_template_part( 'template-parts/headers/header-topbar' ) ?>
			<?php endif; ?>

			<?php get_template_part( 'template-parts/headers/header', GBT_Opt::getOption('header_template') ) ?>

			<div class="sticky_header_placeholder">

				<?php if ( ( 1 == GBT_Opt::getOption('header_sticky_topbar') ) && ( 1 == GBT_Opt::getOption('topbar_toggle') ) ) : ?>

					<?php get_template_part( 'template-parts/headers/header-topbar' ) ?>

				<?php endif; ?>

				<?php if ( 1 == GBT_Opt::getOption('header_sticky_visibility') ) : ?>

					<?php if (GETBOWTIED_WOOCOMMERCE_IS_ACTIVE) { ?>

						<?php if ( is_single() && !is_product() ) { ?>

							<?php get_template_part( 'template-parts/headers/header-sticky', GBT_Opt::getOption('header_template') ) ?>
							<?php get_template_part( 'template-parts/headers/header-sticky-blog' ) ?>

						<?php } elseif ( is_product() ) { ?>
							<?php get_template_part( 'template-parts/headers/header-sticky', GBT_Opt::getOption('header_template') ) ?>

						<?php } else { ?>

							<?php //get_template_part( 'template-parts/headers/header-sticky') ?>
							<?php get_template_part( 'template-parts/headers/header-sticky', GBT_Opt::getOption('header_template') ) ?>

						<?php } ?>

					<?php } else { ?>

						<?php if ( 'post' == get_post_type() ) { ?>

							<?php get_template_part( 'template-parts/headers/header-sticky-blog' ) ?>

						<?php } else { ?>

							<?php //get_template_part( 'template-parts/headers/header-sticky') ?>
							<?php get_template_part( 'template-parts/headers/header-sticky', GBT_Opt::getOption('header_template') ) ?>

						<?php } ?>

					<?php } ?>

				<?php endif; ?>

			</div>

			<?php get_template_part( 'template-parts/headers/header-mobiles' ) ?>
		
		<div class="site-free-shipping-banner" style="margin-top: 0px;">
            
			<?php 
				endif; 
				if( is_page( 'cart' ) || is_page( 'checkout' ) ) {
					do_action('header_free_shipping_banner');
				}
			?>

        </div>
		<div class="site-content-wrapper">
