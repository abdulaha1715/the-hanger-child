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

// Cart & Checkout page banner
if ( ! function_exists( 'header_free_shipping_banner_yellow_banner' ) ) {
    function header_free_shipping_banner_yellow_banner() {
        ?>
        <div class="site-content-wrapper site-free-shipping-banner" style="margin-top: 0px;">
            <div class="row">
                <p>
                <?php 
                    echo "x more and get free shipping"; 
                ?>
                </p>
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

        $arrow_img = get_stylesheet_directory_uri() . '/images/continue-shopping-arrow.png';
        echo '<div class="continue-shopping">';
        echo ' <a href="'.$shop_page_url.'" class="button">'.__('Continue shopping', 'woocommerce').'<img src="'.$arrow_img.'" alt="arrow-right"></a>';
        echo '</div>';
    endif;
}
endif;

/**
* WooCommerce: show all product attributes, separated by comma, on cart page
*/
function isa_woo_cart_attribute_values( $cart_item, $cart_item_key ) {
  
    $item_data  = $cart_item_key['data'];
    $attributes = $item_data->get_attributes();
      
    if ( ! $attributes ) {
        return $cart_item;
    }
      
    $out = $cart_item . '<br /><p class="cart-p-attributes">';
      
    $count = count( $attributes );
      
    $i = 0;
    foreach ( $attributes as $attribute ) {
   
        // skip variations
        if ( $attribute->get_variation() ) {
            continue;
        }
   
        $name = $attribute->get_name();          
        if ( $attribute->is_taxonomy() ) {
 
            $product_id = $item_data->get_id();
            $terms      = wp_get_post_terms( $product_id, $name, 'all' );
               
            // get the taxonomy
            $tax = $terms[0]->taxonomy;
               
            // get the tax object
            $tax_object = get_taxonomy($tax);
               
            // get tax label
            if ( isset ( $tax_object->labels->singular_name ) ) {
                $tax_label = $tax_object->labels->singular_name;
            } elseif ( isset( $tax_object->label ) ) {
                $tax_label = $tax_object->label;
                // Trim label prefix since WC 3.0
                $label_prefix = 'Product ';
                if ( 0 === strpos( $tax_label,  $label_prefix ) ) {
                    $tax_label = substr( $tax_label, strlen( $label_prefix ) );
                }
            }
            $out .= '<span>'. $tax_label . ': </span>';
 
            $tax_terms = array();              
            foreach ( $terms as $term ) {
                $single_term =  esc_html( $term->name ); 
                array_push( $tax_terms, $single_term );
            }
            $out .= implode(', ', $tax_terms);
              
            if ( $count > 1 && ( $i < ($count - 1) ) ) {
                $out .= '</br>';
            }
          
            $i++;
            // end for taxonomies
      
        } else {
  
            // not a taxonomy
            $out .= '<span>'.  $name . ': </span>';
            $out .= esc_html( implode( ', ', $attribute->get_options() ) );
          
            if ( $count > 1 && ( $i < ($count - 1) ) ) {
                $out .= '</br>';
            }
          
            $i++;
        }
    }
    echo $out.= '</p>';
}

add_filter( 'woocommerce_cart_item_name', 'isa_woo_cart_attribute_values', 10, 2 );

/**
 * Why shop here shortcode
 */
function ab_why_shop_here( $atts ) {
    return '<div class="home-below-hero">
            <div class="site-prefooter row small-collapse">

            <div class="prefooter-content">

                <aside class="widget-area">

                    <div class="row small-up-1 medium-up-2 large-up-4">
                        <div class="column"><aside id="theme_ecommerce_info-1" class="widget widget_theme_ecommerce_info"><div class="ecommerce-info-widget-txt-wrapper"><div class="ecommerce-info-widget-title"><div class="ecommerce-info-widget-icon"><i class="thehanger-icons-ecommerce_box-2"></i></div><h4 class="widget-title">Gratis fragt</h4></div><div class="ecommerce-info-widget-subtitle">Ved køb over 399,-</div></div></aside></div><div class="column"><aside id="theme_ecommerce_info-2" class="widget widget_theme_ecommerce_info"><div class="ecommerce-info-widget-txt-wrapper"><div class="ecommerce-info-widget-title"><div class="ecommerce-info-widget-icon"><i class="thehanger-icons-ecommerce_box-transport"></i></div><h4 class="widget-title">Hurtig levering</h4></div><div class="ecommerce-info-widget-subtitle">Vi sender alle hverdage</div></div></aside></div><div class="column"><aside id="theme_ecommerce_info-3" class="widget widget_theme_ecommerce_info"><div class="ecommerce-info-widget-txt-wrapper"><div class="ecommerce-info-widget-title"><div class="ecommerce-info-widget-icon"><i class="thehanger-icons-ui_star"></i></div><h4 class="widget-title">Udvidet returret </h4></div><div class="ecommerce-info-widget-subtitle">30-dages fuld returret</div></div></aside></div><div class="column"><aside id="theme_ecommerce_info-4" class="widget widget_theme_ecommerce_info"><div class="ecommerce-info-widget-txt-wrapper"><div class="ecommerce-info-widget-title"><div class="ecommerce-info-widget-icon"><i class="thehanger-icons-ecommerce_credit-card"></i></div><h4 class="widget-title">Sikker betaling </h4></div><div class="ecommerce-info-widget-subtitle">Betalingskort og MobilePay</div></div></aside></div>                         </div>

                </aside>

                <div class="hover_overlay_footer"></div>

            </div>
        </div>

    </div>';
}
add_shortcode( 'why_shop_here', 'ab_why_shop_here' );

/**
 * Cart page title
 */
function theme_cart_entry_header() {
    ?>
    <header class="cart entry-header">
        <h1 class="entry-title"><?php echo __('Indkøbskurv', 'woocommerce'); ?></h1>
    </header><!-- .entry-header -->
    <?php
}
add_action('woocommerce_before_cart', 'theme_cart_entry_header', 8);

/**
 * Checkout billing fields
 */
function woocommerce_checkout_billing_fields( $checkout_fields ) {

    $checkout_fields['billing']['billing_first_name']['priority'] = 10;
    $checkout_fields['billing']['billing_last_name']['priority']  = 20;
    $checkout_fields['billing']['billing_address_1']['priority']  = 40;
    $checkout_fields['billing']['billing_postcode']['priority']   = 60;
    $checkout_fields['billing']['billing_city']['priority']       = 70;
    $checkout_fields['billing']['billing_email']['priority']      = 100;
    $checkout_fields['billing']['billing_phone']['priority']      = 110;

    unset( $checkout_fields['billing']['billing_country'] );
    
    return $checkout_fields;
}
add_filter( 'woocommerce_checkout_fields', 'woocommerce_checkout_billing_fields' );

/**
 * Shipping billing fields
 */
function woocommerce_checkout_shipping_fields( $checkout_fields ) {

    $checkout_fields['shipping']['shipping_first_name']['priority'] = 10;
    $checkout_fields['shipping']['shipping_last_name']['priority']  = 20;
    $checkout_fields['shipping']['shipping_address_1']['priority']  = 40;
    $checkout_fields['shipping']['shipping_postcode']['priority']   = 60;
    $checkout_fields['shipping']['shipping_city']['priority']       = 70;
    $checkout_fields['shipping']['shipping_phone']['priority']      = 110;

    unset( $checkout_fields['shipping']['shipping_company'] );
    unset( $checkout_fields['shipping']['shipping_country'] );
    unset( $checkout_fields['shipping']['shipping_address_2'] );
    
    return $checkout_fields;
}
add_filter( 'woocommerce_checkout_fields', 'woocommerce_checkout_shipping_fields' );

/**
 * shipping email checkout fields
 */
function shipping_email_checkout_fields( $fields ) {
     $fields['shipping']['shipping_email'] = array(
        'label'     => __('Email address', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-wide'),
        'clear'     => true,
        'priority' => 100
     );

     return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'shipping_email_checkout_fields' );

/**
 * Woocommerce placeholder img
 */
function dev_custom_woocommerce_placeholder_img_src( $src ) {
    // replace with path to your image
    $src = get_stylesheet_directory_uri() . '/images/no-product-image.png';
     
    return $src;
}
add_filter('woocommerce_placeholder_img_src', 'dev_custom_woocommerce_placeholder_img_src', 50);

function dev_custom_woocommerce_placeholder_img( $image_html, $size, $dimensions ){
    $image = get_stylesheet_directory_uri() . '/images/no-product-image.png';
    $image_html = '<img src="' . esc_attr( $image ) .'" alt="' . esc_attr__( 'Placeholder Img', 'woocommerce' ) . '" width="' . esc_attr( $dimensions['width'] ) . '" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" height="' . esc_attr( $dimensions['height'] ) . '" />';
    return $image_html;
}
add_filter('woocommerce_placeholder_img', 'dev_custom_woocommerce_placeholder_img', 10, 3);
