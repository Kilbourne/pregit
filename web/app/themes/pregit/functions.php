<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);


add_filter( 'gform_column_input_1_5_3', 'set_column', 10, 5 );
function set_column( $input_info, $field, $column, $value, $form_id ) {
    return array( 'type' => 'date');
}
add_filter( 'gform_column_input_1_5_1', 'set_column2', 10, 5 );
function set_column2( $input_info, $field, $column, $value, $form_id ) {
    return array( 'type' => 'post-select','args'=>array(
      'post_type' => 'product',
      'meta_query' => array(
    array(
      'key' => 'produttore',
      'value' => '3',
      'compare' => 'LIKE'
    ))
      ),'value'=>'ID',"text"=>'post_title' );
}

// Disabilità opzione se già usate
// se max row
