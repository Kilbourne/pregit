<?php

use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes();?>>
  <?php get_template_part('templates/head');
$title = get_field('show_title', get_the_id()) ? 'page_title' : '';
?>
  <body <?php body_class($title);?>>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage');?>
      </div>
    <![endif]-->
    <?php do_action('body_open');?>
    <div class="page-wrapper" role="document">
    <?php
do_action('get_header');
get_template_part('templates/header');

?>

      <div class="content row">
      <?php if (is_front_page()) {
    ?>
      <div class="divi-slider header-slide">
              <div class="et_builder_outer_content" id="et_builder_outer_content">
        <div class="et_builder_inner_content et_pb_gutters3">
        <?php
        $default_slider_id = get_page_by_title('Header Slider')->ID;
        $lang_slider_id = apply_filters( 'wpml_object_id', $default_slider_id, 'page' );

echo do_shortcode(get_post($lang_slider_id)->post_content);

    ?>
        </div></div></div><?php }?>
        <main class="main">
          <?php include Wrapper\template_path();?>
        </main><!-- /.main -->
        <?php if (false): ?>
          <aside class="sidebar">
            <?php include Wrapper\sidebar_path();?>
          </aside><!-- /.sidebar -->
        <?php endif;?>
      </div><!-- /.content -->

    <?php
get_template_part('templates/footer');
do_action('get_footer');
?>
</div><!-- /.wrap -->
<?php
do_action('body_close');
?>

<?php
wp_footer();
?>

  </body>
</html>
