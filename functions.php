<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );


/////////////
// custom code starts here



// test adding a link at the top of the single product page before summary. 
add_action('woocommerce_before_single_product_summary',function(){
    printf('<h4><a href="?added-content">Congratulations, you\'ve just added a link!</a></h4>');




//test adding a logo after the buy button before the product number
add_action( 'woocommerce_product_meta_start', 'quadlayers_woocommerce_hooks');
function quadlayers_woocommerce_hooks() {
echo '<img src="https://kokohai.com/wp-content/uploads/2020/02/logo-kokohai-tienda-de-merchandising-de-anime-y-maga-e1584570981420.png">'; // Change to desired image url
}

// test with getting gallery image 1
// Thread about how to get the image: https://wordpress.stackexchange.com/questions/220029/how-to-get-the-first-image-gallery-of-a-product-in-woocommerce-in-a-loop
//Along with the product thumbnail (I'm assuming you have this), what you need is a list (array) of the product images 
//- WooCommerce has such methods, eg $product->get_gallery_attachment_ids().
//You can grab the first ID in the array and use it to fetch the single image using wp_get_attachment_image(), 
//or wp_get_attachment_url(), etc., then use that as an alternate source for the main (thumbnail) image.
//Incidentally, the woocommerce_product_thumbnails call is outputting markup that you probably don't want to use. 
//You'll need to either discard this or unhook functions from it to get the output you want.

// Then look at this: https://stackoverflow.com/questions/29778288/get-woocommerce-product-gallery-image-caption
function wp_get_attachment( $attachment_id ) {

    $attachment = get_post( $attachment_id );
    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}
//Don't know if I will need the two lines here else delete.
//wp_get_attachment_url( $attachment_ids[0], 'large')
//do_action( 'woocommerce_product_thumbnails' ); 


//Remove main image and add thumbnail images
//remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
//add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_thumbnails', 20 );


// Remove product thumbnail gallery
// http://hookr.io/actions/woocommerce_product_thumbnails/
// https://www.businessbloomer.com/woocommerce-visual-hook-guide-single-product-page/
// https://wpsites.net/genesis-tutorials/remove-woocommerce-single-thumbnail-images-from-product-details-page/
// https://stackoverflow.com/questions/27604023/woocommerce-main-product-image
// https://stackoverflow.com/questions/55705514/how-to-override-woocommerce-product-image-template
// https://woocommerce.com/document/template-structure/
//remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
//Remove related products output
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
// Up-sells sorting
add_filter( 'woocommerce_upsells_orderby', function() { return 'menu_order'; } );
add_filter( 'woocommerce_upsells_order', function() { return 'asc'; } );
////////////////// Custom code ends here
  }
  );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'getbowtied_icons','motion-ui','thehanger-styles','getbowtied-default-fonts' ) );
        //Yoast faq accordion js file
        //Code: https://labs.freddielore.com/yoast-faq-block-collapsible-headers-accordions/
        //Guide followed: https://betterprogramming.pub/how-to-add-javascript-to-wordpress-a4fdc7618a21
        // Useful info: https://developer.wordpress.org/themes/basics/including-css-javascript/
        wp_enqueue_script( 'yoast-faq', get_stylesheet_directory_uri() . '/js/yoast-faq.js', array('jquery'), '', true );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );


// remove some fields from billing form
add_filter('woocommerce_billing_fields','wpb_custom_billing_fields');
// ref - https://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
function wpb_custom_billing_fields( $fields = array() ) {

	unset($fields['billing_company']);
	unset($fields['billing_address_2']);
	unset($fields['billing_state']);

	return $fields;
}

//reorder fileds at billing
//ref - https://rudrastyh.com/woocommerce/reorder-checkout-fields.html
add_filter( 'woocommerce_checkout_fields', 'beibi_email_first' );

function beibi_email_first( $checkout_fields ) {
	$checkout_fields['billing']['billing_email']['priority'] = 4;
    $checkout_fields['billing']['billing_phone']['priority'] = 5;
    $checkout_fields['billing']['billing_city']['priority'] = 91;
    $checkout_fields['billing']['billing_country']['priority'] = 92;
	return $checkout_fields;
}

//Style billing form fields 
//ref - https://rudrastyh.com/woocommerce/checkout-fields.html#change_order
//doesn't work with postcode and city but works fine with phone and email
add_filter( 'woocommerce_checkout_fields' , 'beibi_checkout_fields_styling', 9999 );

function beibi_checkout_fields_styling( $f ) {

	$f['billing']['billing_email']['class'][0] = 'form-row-first';
	$f['billing']['billing_phone']['class'][0] = 'form-row-last';
    $f['billing']['billing_postcode']['class'][0] = 'form-row-first';
	//$f['billing']['billing_city']['class'][0] = 'form-row-last';
	
	return $f;

}


//Checkout - change labels
//ref - https://rudrastyh.com/woocommerce/checkout-fields.html#change_order
add_filter( 'woocommerce_checkout_fields' , 'beibi_labels_placeholders', 9999 );

function beibi_labels_placeholders( $f ) {

	// first name can be changed with woocommerce_default_address_fields as well
    // labels doesn't change as it's said they should... 
	$f['billing']['billing_address_1']['label'] = 'Adresse';
    $f['order']['order_comments']['label'] = 'Tilf&oslash;j bem&aelig;rkninger til ordren.';
	$f['order']['order_comments']['placeholder'] = 'Evt bem&aelig;rkning til din ordre (til Beibi, ikke til fragtselskabet)';
	
	return $f;

}

//Checkout - move billing to first column
// ref - https://www.ibenic.com/move-payments-woocommerce-checkout/



if ( ! function_exists( 'header_free_shipping_banner_yellow_banner' ) ) {
    function header_free_shipping_banner_yellow_banner() {
        ?>
        <div class="site-content-wrapper site-free-shipping-banner" style="margin-top: 0px;">
            <div class="row small-collapse">
                <div class="small-12 columns">
                    <div class="site-content">
                        <p>
                        <?php 
                            echo "x more and get free shipping"; 
                        ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

add_action('header_free_shipping_banner', 'header_free_shipping_banner_yellow_banner');




//==============================================================================
//  Continue shopping button on cart page
//==============================================================================

add_action( 'woocommerce_after_cart_totals', 'add_continue_shopping_button_to_cart' );
if  ( ! function_exists('add_continue_shopping_button_to_cart') ) :
    function add_continue_shopping_button_to_cart() {
    $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
    if (!empty($shop_page_url)):
        echo '<div class="continue-shopping">';
        echo ' <a href="'.$shop_page_url.'" class="button">'.__('Continue shopping', 'woocommerce').'<i class="thehanger-icons-arrow-right"></i></a>';
        echo '</div>';
    endif;
}
endif;


