<?php
namespace Roots\Sage\Extras;

add_filter('um_account_secure_fields', function ($fields, $id) {
    if ($id === 'general') {
        global $ultimatemember;
        $form = $ultimatemember->user->get_role() === 'produttore' ? 'duplicato-di-default-registration' : 'default-registration';
        $aaa  = new \WP_Query(array(
            'post_type'     => 'um_form',

            "post_name__in" => [$form],
            'post_status'   => array('publish'),
        ));
        return get_post_meta($aaa->posts[0]->ID, '_um_custom_fields')[0];
    }
    return $fields;
}, 10, 2);

add_filter('gform_field_value_product_id', __NAMESPACE__ . '\\my_custom_population_function');
function my_custom_population_function($value)
{
    global $post;
    return $post->ID;
}

add_filter('gform_column_input_6_5_3', __NAMESPACE__ . '\\set_column', 10, 5);
function set_column($input_info, $field, $column, $value, $form_id)
{
    return array('type' => 'date');
}
add_filter('gform_column_input_6_5_1', __NAMESPACE__ . '\\set_column2', 10, 5);
function set_column2($input_info, $field, $column, $value, $form_id)
{
    $user = wp_get_current_user();
    return array('type' => 'post-select', 'args' => array(
        'post_type' => 'product',
        'tax_query' => array(
            array(
                'taxonomy' => 'producer',
                'field'    => 'slug',
                'terms'    => $user->user_login,
            ),
        ),
    ), 'value' => 'ID', "text" => 'post_title');
}

add_filter('um_account_page_default_tabs_hook', __NAMESPACE__ . '\\form_tab', 100);
function form_tab($tabs)
{

    global $ultimatemember;
    if ($ultimatemember->user->get_role() === 'produttore') {
        $tabs[235]['order_form'] = [
            'icon'   => 'um-faicon-pencil',
            'title'  => 'Order Form',
            'custom' => true,
        ];
    }
    if ($ultimatemember->user->get_role() === 'distributore') {
        $tabs[235]['docs'] = [
            'icon'   => 'um-faicon-file-text-o',
            'title'  => 'Documenti Distributore',
            'custom' => true,
        ];
    }
    return $tabs;

}
add_action('um_account_tab__order_form', __NAMESPACE__ . '\\um_account_tab__mytab');
function um_account_tab__mytab($info)
{
    global $ultimatemember;
    extract($info);

    echo do_shortcode('[gravityform id="6" ajax="true"]');

}

add_action('um_after_account_page_load', __NAMESPACE__ . '\\insert_producer_gf');
function insert_producer_gf()
{
    echo do_shortcode('[gravityform id="6" ajax="true"]');
}

add_action('um_account_tab__docs', __NAMESPACE__ . '\\um_account_tab__docs');
function um_account_tab__docs($info)
{
    $query = new \WP_Query(array(
        'numberposts' => -1,
        'post_type'   => 'attachment',
        'post_status' => 'inherit',
        'meta_key'    => 'documento_distributore',
        'meta_value'  => true,
    ));

    if ($query->posts) {
        ?>
        <div class="documento-distributore-wrapper">
        <ul class="documento-distributore-list">
        <?php foreach ($query->posts as $key => $post) {
            echo '<li class="documento-distributore"><span class="documento-distributore-date" >' . get_the_date('j F y', $post->ID) . '</span><a href="' . wp_get_attachment_url($post->ID) . '" class="documento-distributore-link">' . get_the_title($post->ID) . '</a></li> ';
        }
        ?></ul></div>   <?php
}
}
/*
add_action('um_after_new_user_register', function ($user_id) {
global $um_mailchimp;
$um_mailchimp->api->user_id = $user_id;
$lists                      = $um_mailchimp->api->has_lists();
delete_option("um_cache_userdata_{$user_id}");

foreach ($lists as $post_id) {
$list = $um_mailchimp->api->fetch_list($post_id);
if (!$um_mailchimp->api->is_subscribed($list['id'])) {
$um_mailchimp->api->subscribe($list['id'], $list['merge_vars']);
}

}
}, 10);
 */
