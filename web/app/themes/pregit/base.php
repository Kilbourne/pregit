<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <div class="page-wrapper" role="document">
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>
    
      <div class="content row">
        <main class="main">
        <div class="et_builder_outer_content" id="et_builder_outer_content">
        <div class="et_builder_inner_content et_pb_gutters3">
        <?php echo do_shortcode(get_page_by_title('Header Slider')->post_content); ?>
        </div></div>
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
        <?php if (false) : ?>
          <aside class="sidebar">
            <?php include Wrapper\sidebar_path(); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
      </div><!-- /.content -->
    
    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
    </div><!-- /.wrap -->
  </body>
</html>
