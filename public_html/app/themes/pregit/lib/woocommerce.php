<?php
namespace Roots\Sage\Extras;

add_filter('single_product_large_thumbnail_size', __NAMESPACE__ . '\\pregit_single_product_thumb_size');
function pregit_single_product_thumb_size()
{
    return 'full';
}

remove_all_actions('woocommerce_after_single_product_summary');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_before_single_product', 'wc_print_notices', 10);
add_action('woocommerce_before_main_content', 'wc_print_notices', 15);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

add_filter('woocommerce_add_to_cart_fragments', __NAMESPACE__ . '\\woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment($fragments)
{
    ob_start();
    ?>
  <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php __('Cart', 'sage');?>"><i class="fa fa-shopping-cart"></i><span class="wcmenucart-text">(<span class="cart-length">
  <?php echo WC()->cart->get_cart_contents_count(); ?> </span>) <?php _e('Cart', 'sage')?></span></a>

  <?php

    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}

function wc_product_columns_frontend()
{
    global $woocommerce;

    // Default Value also used for categories and sub_categories
    $columns = 4;

    // Product List
    if (is_tax(['product_cat', 'producer']) || is_shop()):
        $columns = 3;
    endif;

    return $columns;

}
add_filter('woocommerce_single_product_image_html', function ($html) {
    return strip_tags($html, '<img><noscript>');
});
add_filter('loop_shop_columns', __NAMESPACE__ . '\\wc_product_columns_frontend');

add_filter('woocommerce_subcategory_count_html', function () {return '';});

add_filter('woocommerce_product_is_on_sale', function () {
    global $product;
    if ($product->get_sale_price() === '') {
        return false;
    }

});
add_filter('woocommerce_breadcrumb_home_url', function () {
    $shop_page_id = wc_get_page_id('shop');
    $shop_page    = get_post($shop_page_id);
    return get_permalink($shop_page);});

add_filter('woocommerce_breadcrumb_defaults', function ($args) {
    if (!is_shop()) {
        $shop_page_id = wc_get_page_id('shop');
        $shop_page    = get_post($shop_page_id);
        $args['home'] = get_the_title($shop_page);
    } else {
        unset($args['home']);
    }
    /*
    if (isset($_SERVER['HTTP_REFERER']) && $referer = $_SERVER['HTTP_REFERER']) {
    $myDomain = $_SERVER['WP_HOME'];
    if (parse_url($myDomain, PHP_URL_HOST) === parse_url($referer, PHP_URL_HOST)) {
    $url                 = htmlspecialchars($referer);
    $args['wrap_before'] = '<nav class="woocommerce-breadcrumb"><a href="' . $url . '" >' . __('Torna Indietro', 'sage') . '</a>';
    }
    }
     */
    return $args;});
