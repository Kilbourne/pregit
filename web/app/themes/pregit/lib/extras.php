<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

add_filter('single_product_large_thumbnail_size', __NAMESPACE__ . '\\pregit_single_product_thumb_size' );
function pregit_single_product_thumb_size(){
  return 'full';
}
add_filter( 'gform_field_value_product_id', __NAMESPACE__ . '\\my_custom_population_function' );
function my_custom_population_function( $value ) {
 global $post;
 return $post->ID;
}

function remove_producer_metaboxe_from_product_edit() {
    remove_meta_box( 'tagsdiv-producer', 'product', 'side' );
}
add_action( 'add_meta_boxes_product' , __NAMESPACE__ . '\\remove_producer_metaboxe_from_product_edit' );



function save_producer_tax_terms( $post_id ) {
  if ( 'product' != get_post_type($post_id) || wp_is_post_revision( $post_id ) ) return;
  $taxonomy = 'producer';
  $product_producers = get_post_meta( $post_id, 'produttore' )[0];
  $terms=array();
  foreach ($product_producers as $key => $user_id) {
    $user = get_userdata($user_id);
    $term = $user->user_login ;

    if( ! term_exists( $term, $taxonomy )) wp_insert_term( $term, $taxonomy, array('slug'=>'produttore_'.$user_id) );
    $terms[] =  'produttore_'.$user_id;
  }
  if($terms) wp_set_object_terms( $post_id , $terms, $taxonomy);


}
add_action( 'save_post', __NAMESPACE__ . '\\save_producer_tax_terms' );
add_action( 'user_register', __NAMESPACE__ . '\\on_producer_register_add_to_tax', 10, 1 );

function on_producer_register_add_to_tax( $user_id ) {
    $user = get_userdata($user_id);
    if ( in_array( 'producer', (array) $user->roles )  && ! term_exists($user->user_login , 'producer' ) )
        wp_insert_term( $user->user_login , 'producer', array('slug'=>'produttore_'.$user_id) );

}

add_action( 'init', __NAMESPACE__ . '\\cptui_register_my_taxes_producer' );
function cptui_register_my_taxes_producer() {
  $labels = array(
    "name" => __( 'Produttori', 'sage' ),
    "singular_name" => __( 'Produttore', 'sage' ),
    );

  $args = array(
    "label" => __( 'Produttori', 'sage' ),
    "labels" => $labels,
    "public" => true,
    "hierarchical" => false,
    "label" => "Produttori",
    "show_ui" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => false,
    "query_var" => true,
    "rewrite" => array( 'slug' => 'producer', 'with_front' => true, ),
    "show_admin_column" => false,
    "show_in_rest" => false,
    "rest_base" => "",
    "show_in_quick_edit" => false,
  );
  register_taxonomy( "producer", array( "product" ), $args );

// End cptui_register_my_taxes_producer()
}
// Disable Producer ADD UI
function remove_edit_producer_ui(){
  if(get_current_screen()->id !=='edit-producer') return;
  echo "<script type='text/javascript'>\n";
  echo '(function($) { $(function(){$("#col-left").remove();$("#col-right").css("width","100%");})
})(jQuery);';
  echo "\n</script>";
}
add_action( 'admin_print_scripts',  __NAMESPACE__ . '\\remove_edit_producer_ui',50 );

add_filter( 'gform_column_input_1_5_3', __NAMESPACE__ . '\\set_column', 10, 5 );
function set_column( $input_info, $field, $column, $value, $form_id ) {
    return array( 'type' => 'date');
}
add_filter( 'gform_column_input_1_5_1',__NAMESPACE__ . '\\set_column2', 10, 5 );
function set_column2( $input_info, $field, $column, $value, $form_id ) {
    return array( 'type' => 'post-select','args'=>array(
      'post_type' => 'product',
      'tax_query' => array(
        array(
          'taxonomy' => 'producer',
          'field' => 'slug',
          'terms' => 'produttore_'.get_current_user_id()
        )
      )
    ),'value'=>'ID',"text"=>'post_title' );
}
