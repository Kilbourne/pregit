<footer class="content-info">
<div class="logo"><img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/pregit_logo.svg" alt="" class="logo-img" width="90" height="90"></div>
  <div class="container">
          <?php
if (has_nav_menu('primary_navigation')):
    wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'nav']);
endif;
?>
  </div>
  <div class="last-line"><span class="left"> &copy; 2016 I Pregi d’Italia </span><span class="right">Credits</span>
   </div>
</footer>
