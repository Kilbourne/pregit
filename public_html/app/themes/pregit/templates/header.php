<?php
function sk_wcmenucart()
{

    // Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
    if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        return;
    }

    ob_start();
    global $woocommerce;
    $viewing_cart        = __('Cart', 'sage');
    $cart_url            = $woocommerce->cart->get_cart_url();
    $cart_contents_count = $woocommerce->cart->cart_contents_count;
    $cart_contents       = sprintf(_n('%d  item', '%d items', $cart_contents_count, 'sage'), $cart_contents_count);
    // Uncomment the line below to hide nav menu cart item when there are no items in the cart
    if ($cart_contents_count > 0) {

        $menu_item = '<a class="cart-contents" href="' . $cart_url . '" title="' . $viewing_cart . '">';

        $menu_item .= '<i class="fa fa-shopping-cart"></i> ';

        $menu_item .= '<span class="wcmenucart-text">(<span class="cart-length">' . $cart_contents_count . '</span>) ' . $viewing_cart;
        $menu_item .= '</span></a>';
        // Uncomment the line below to hide nav menu cart item when there are no items in the cart
        echo $menu_item;
    }

    $social = ob_get_clean();
    return $social;

}
?>
<header class="banner">
    <div class="first-line"><span class="left"> IT | EN </span>
    <span class="right">

         <?php
/*
$UM_plinks = (new UM_Permalinks)->core;
if (is_user_logged_in()) {
echo '<div class="account-link"><div><a href="' . get_permalink($UM_plinks['account']) . '">' . __('Profilo', 'sage') . ' </a> | <a href="' . esc_url(get_permalink($UM_plinks['logout'])) . '">' . __('Scollegati', 'sage') . '</a></div></div>';
} elseif (!is_user_logged_in()) {

}
 */
echo '<div class="account-link"><div><a class="responsive-menu-pro-item-link" href="' . get_permalink(get_page_by_title(__('Contacts', 'sage'))->ID) . '">' . __('Contact us', 'sage') . ' </a></div></div>';
$query = isset($_GET['searchwpquery']) ? sanitize_text_field($_GET['searchwpquery']) : '';
?>
    <div class="cart-icon-container"> <?php echo sk_wcmenucart(); ?></div>
    <form action="<?php echo get_permalink(922); ?>" id="responsive_menu_pro_search" method="get" role="search">
     <i class="fa fa-search"></i>
            <input type="search" name="searchwpquery" value="<?php echo esc_attr($query); ?>" placeholder="<?php _e('Cerca', 'responsive-menu-pro');?>" id="responsive_menu_pro_search_input">
        </form>


    </span></div>
    <div class="container">
      <div class="logo"><a href="<?php echo get_home_url(); ?> "><img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/pregit_logo.svg" alt="I predi d\'Italia logo"
 width="60" height="60" class="logo-img"></a></div>
      <div class="nav-container">
      <nav class="nav-primary">
      <?php
if (has_nav_menu('primary_navigation')):
    wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
endif;
?>
    </nav>
    </div>
    <?php echo do_shortcode(' [responsive_menu_pro title_link="' . get_home_url() . '" ]'); ?>
    </div>
</header>
