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
function my_theme_plugins_loaded_is_loaded() {
    if ( function_exists( 'my_theme_function' ) ) {
        my_theme_function();
        add_action('header_free_shipping_banner', 'header_free_shipping_banner_yellow_banner');
    }
}
add_action( 'plugins_loaded', 'my_theme_plugins_loaded_is_loaded' );



//==============================================================================
//  Continue shopping button on cart page
//==============================================================================

add_action( 'woocommerce_after_cart_totals', 'add_continue_shopping_button_to_cart' );
if  ( ! function_exists('add_continue_shopping_button_to_cart') ) {
    function add_continue_shopping_button_to_cart() {
        $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
        if (!empty($shop_page_url)) {

            $arrow_img       = get_stylesheet_directory_uri() . '/images/continue-shopping-arrow.png';
            $hover_arrow_img = get_stylesheet_directory_uri() . '/images/continue-shopping-arrow-hover.png';

            echo '<div class="continue-shopping">';
            echo ' <a href="'.$shop_page_url.'" class="button">'.__('Continue shopping', 'woocommerce').'<img class="normal-arrow" src="'.$arrow_img.'" alt="arrow-right"><img class="hover-arrow" src="'.$hover_arrow_img.'" alt="arrow-right"></a>';
            echo '</div>';
        }
    }
}

/**
 * Why shop here shortcode with widget data
 */
function ab_why_shop_here( $atts ) {

    $widgets = wp_get_sidebars_widgets();
    $prefooter_area_widgets_counter = 6;
    if( $widgets && isset($widgets['prefooter-widget-area']) ) {
        $prefooter_area_widgets_counter = (count($widgets['prefooter-widget-area']) >= 7) ? 6 : count($widgets['prefooter-widget-area']);

        foreach( $widgets['prefooter-widget-area'] as $k ) {
            if(strpos($k, 'monster-') !== false) {
                $prefooter_area_widgets_counter = 6;
            }
        }
    }

    if( isset($widgets['prefooter-widget-area']) && is_active_sidebar( 'prefooter-widget-area' ) ) : 
        ?>

    <div class="site-prefooter">

        <?php if (isset($widgets['prefooter-widget-area'])) : ?>

            <div class="row small-collapse">

                <div class="large-12 columns">

                    <div class="prefooter-content">

                        <aside class="widget-area">

                            <div class="row small-up-1 medium-up-2 large-up-<?php echo esc_attr($prefooter_area_widgets_counter); ?>">
                                <?php dynamic_sidebar( 'prefooter-widget-area' ); ?>
                            </div>

                        </aside>

                        <div class="hover_overlay_footer"></div>

                    </div>

                </div>
            </div>

        <?php endif; ?>

    </div>

<?php endif;

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

/**
 * checkout right payment
 */
function display_checkout_right_payment() {
   ?>
    <div class="checkout-right-payment">
        <h3 id="payment">
            <?php esc_html_e( 'Betaling', 'woocommerce' ); ?>
        </h3>
        <?php do_action('checkout_right_payment'); ?>
    </div>
   <?php
}
add_action( 'woocommerce_before_order_notes', 'display_checkout_right_payment' );

add_action( 'checkout_right_payment', 'woocommerce_checkout_payment' );

/**
 * Shipment title
 */
function custom_shipping_package_name( $name ) {
    return 'Forsendelsesmetode';
}
add_filter( 'woocommerce_shipping_package_name', 'custom_shipping_package_name' );

// Change "Add to Cart" > "Add to Bag" in Shop Page
function woocommerce_shop_page_add_to_cart_callback() {
    return __( 'Læg i kurven', 'woocommerce' );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_shop_page_add_to_cart_callback', 50 );  

// Single Product
add_filter( 'single_add_to_cart_text', 'custom_single_add_to_cart_text' );
function custom_single_add_to_cart_text() {
    return __( 'Læg i kurven', 'woocommerce' );
}

// Change "Add to Cart" > "Add to Bag" in Single Page
function woocommerce_single_page_add_to_cart_callback() {
    return __( 'Læg i kurven', 'woocommerce' );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_single_page_add_to_cart_callback' ); 

/**
 * Add product category class in body 
 */
function wc_product_cats_css_body_class( $classes ){
    if ( is_singular( 'product' ) ) {
        $current_product = wc_get_product();
        $custom_terms    = get_the_terms( $current_product->get_id(), 'product_cat' );
        
        if ( $custom_terms ) {
            foreach ( $custom_terms as $custom_term ) {
                $classes[] = 'product_cat_' . $custom_term->slug;
            }
        }
    }
    return $classes;
}
add_filter( 'body_class', 'wc_product_cats_css_body_class' );

/**
 * Add book two image 
 */
function woocommerce_single_product_book_two_image () {
    ?>
    <div class="two-image-product-images">
        <div class="first-image">
            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );  ?>
                                        
            <img src="<?php  echo $image[0]; ?>" data-id="<?php echo $loop->post->ID; ?>">
        </div>
        <div class="secound-image">
            <?php do_action( 'woocommerce_product_thumbnails' ); ?>
        </div>
    </div>
    <?php
}
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_single_product_book_two_image' );

/**
 * Quantity button after input
 */
function wqb_product() { echo "
    <div class='quantity-button'>
        <button type='button' title='Decrease quantity' class='minus qty' onclick='wqb_action(0,-1)'></button>
        <button type='button' title='Increase quantity' class='plus qty' onclick='wqb_action(0,1)'></button>
    </div>";
}
add_action('woocommerce_after_add_to_cart_quantity','wqb_product');

/**
 * Cart Quantity button function
 */
function ab_cart_quantity_contents() { echo "
    <script type='text/javascript'>
    function wqb_init_cart() {
        if(document.getElementsByClassName('minus').length>0) return;
        var qty=document.getElementsByClassName('quantity');
        if(!qty) return;
        for(i=0; i<qty.length; i++) {
            qty[i].innerHTML+=\"<div class='quantity-button'><button type='button' title='Decrease quantity' class='minus qty' onclick='wqb_action(\"+i+\",-1)'></button><button type='button' title='Increase quantity' class='plus qty' onclick='wqb_action(\"+i+\",1)'></button></div>\";
        }
    }
    wqb_init_cart();
    setInterval(function(){wqb_init_cart();},3000);
    </script>";
}
add_action('woocommerce_after_cart','ab_cart_quantity_contents');

/**
 * Cart Quantity button function
 */
function ab_cart_quantity_action_assets() { 
    echo "
    <script type='text/javascript'>
        function wqb_action(iteration,q) {
            var qty=[].slice.call(document.querySelectorAll('div.quantity'));
            if(!qty) return;
            for(i=0; i<qty.length; i++) if(i==iteration) {
                v=qty[i].childNodes[3];
                if(!v) return;
                if(v.value<=1 && q<1) return;
                v.value=parseInt(v.value)+parseInt(q);
            }
            if(document.getElementsByName('update_cart').length>0) {
                update_cart=document.getElementsByName('update_cart')[0];
                update_cart.disabled=false;
                update_cart.classList.add('update_cart');
            } else {
                var ev=new Event('change',{bubbles:true});
                v.dispatchEvent(ev);
            }
        }
    </script>";
}
add_action('woocommerce_after_cart_contents','ab_cart_quantity_action_assets');
add_action('woocommerce_after_add_to_cart_quantity','ab_cart_quantity_action_assets');

/**
* WooCommerce: Product attribute value with label in cart
*/
add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false');
add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false');

/**
* WooCommerce: remove attribute name from title
*/
function variation_title_not_include_attributes( $boolean ){
    if ( is_page( 'cart' ) || is_cart() ) {
        $boolean = false;
    } elseif ( is_page( 'checkout' ) || is_checkout() ) {
        $boolean = true;
    }

    return $boolean;
}
// add_filter( 'woocommerce_product_variation_title_include_attributes', 'variation_title_not_include_attributes', 50 );

/**
 * Add a new settings tab to the WooCommerce settings tabs array.
 */
function awr_woo_free_shipping_add_settings_tab( $settings_tabs ) {
    $settings_tabs['settings_tab_demo'] = __( 'Free Shipping', 'woocommerce' );
    return $settings_tabs;
}
add_filter( 'woocommerce_settings_tabs_array', 'awr_woo_free_shipping_add_settings_tab', 50 );

/**
 * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
 */
function awr_woo_free_shipping_settings_tab() {
    woocommerce_admin_fields( ab_fs_get_settings() );
}
add_action( 'woocommerce_settings_tabs_settings_tab_demo', 'awr_woo_free_shipping_settings_tab' );

/**
 * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
 */
function awr_woo_free_shipping_update_settings() {
    woocommerce_update_options( ab_fs_get_settings() );
}
add_action( 'woocommerce_update_options_settings_tab_demo', 'awr_woo_free_shipping_update_settings' );

/**
 * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
 */
function ab_fs_get_settings() {

    $settings = array(
        'section_title' => array(
            'name'     => __( 'Free Shipping Setup', 'woocommerce' ),
            'type'     => 'title',
            'desc'     => '',
            'id'       => 'free_shipping_tab_section_title'
        ),
        'title' => array(
            'name' => __( 'Free Shipping Value', 'woocommerce' ),
            'type' => 'number',
            'desc' => __( 'Type Free Shipping Value here', 'woocommerce' ),
            'id'   => 'free_shipping_value'
        ),
        'section_end' => array(
            'type' => 'sectionend',
            'id' => 'redirect_tab_section_end'
        )
    );

    return apply_filters( 'wc_settings_tab_demo_settings', $settings );
}

/**
 * font-family
 */
function ab__thehanger_custom_styles() {

    $ab__custom_styles = '

        .site-free-shipping-banner p,
        span.shipping-title,
        ul#shipping_method li .shipping_pickup_cart,
        span.cart-p-attributes,
        .checkout-right-shipping h3#delivery-method,
        .checkout-right-payment h3#payment,
        .woocommerce-shipping-destination,
        .shipping-calculator-button,
        ul#shipping_method li label,
        .shipmondo-modal-wrapper,
        .page_as_post_header p#breadcrumbs,
        .site-free-shipping-banner #wfspb-top-bar #wfspb-main-content,
        .schema-faq-question,
        tr.woocommerce-cart-form__cart-item.cart_item
        {
            font-family: ' . esc_html(GBT_Opt::getOption('secondary_font')['font-family']) . ', sans-serif;
        }

        .wp-block-verse pre
        {
            font-family: ' . esc_html(GBT_Opt::getOption('main_font')['font-family']) . ', sans-serif;
        }

        .wp-block-latest-comments .wp-block-latest-comments__comment-link
        {
            font-size: ' . esc_html(GBT_Opt::getOption('font_size')) . 'px;
        }

        .edit-post-visual-editor .block-editor-block-list__block h1
        {
            font-size: ' . 2.5 * esc_html(GBT_Opt::getOption('font_size')) . 'px;
        }
        
        .page_as_post_header p#breadcrumbs,
        tr.woocommerce-cart-form__cart-item.cart_item,
        .site-free-shipping-banner div#wfspb-top-bar,
        .site-free-shipping-banner #wfspb-top-bar #wfspb-main-content,
        span.shipping-title,
        ul#shipping_method li,
        span.cart-p-attributes,
        .single-product input.qty.text,
        table.shop_table.woocommerce-checkout-review-order-table td.product-name,
        table.shop_table.woocommerce-checkout-review-order-table td.product-total,
        body.woocommerce-cart .woocommerce .woocommerce-cart-form tr.cart_item .product-name a,
        p.woocommerce-notice.woocommerce-notice--success.woocommerce-thankyou-order-received,
        p.d-p-bank,
        dl.variation p
        {
            color: ' . esc_html(GBT_Opt::getOption('secondary_color')) . ' !important;
        }
    ';

    wp_add_inline_style( 'chld_thm_cfg_child', $ab__custom_styles );

}
add_action( 'wp_enqueue_scripts', 'ab__thehanger_custom_styles' );
