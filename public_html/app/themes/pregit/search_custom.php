<?php
/**
 * Template Name: Custom Search
 */
?>

  <?php
global $post;
$query = isset( $_GET['swpquery'] ) ? sanitize_text_field( $_GET['swpquery'] ) : '';
$page = isset( $_GET['swppg'] ) ? absint( $_GET['swppg'] ) : 1;
the_post();
 ?>

  <div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

      <?php if( !empty( $query ) ) : ?>
        <header class="page-header">
          <h1 class="page-title">Search Results for: <?php echo $query; ?></h1>
        </header>
      <?php endif; ?>

      <div class="entry-content">
        <form action="" method="get">
          <fieldset>
            <legend>Supplemental Search</legend>
            <p>
              <label for="swpquery">Search</label>
              <input type="text" id="swpquery" name="swpquery" value="<?php echo esc_attr( $query ); ?>" />
            </p>
            <p><button type="submit">Search</button></p>
          </fieldset>
        </form>
      </div>

      <?php if( !empty( $query ) ) : ?>

        <?php
          $engine = SearchWP::instance();             // instatiate SearchWP
          $supplementalEngineName = 'supplemental';   // search engine name
          // perform the search
          $posts = $engine->search( $supplementalEngineName, $query, $page );
        ?>

        <?php if( !empty( $posts ) ) : ?>
          <?php foreach( $posts as $post ) : ?>
            <?php if( $post instanceof SearchWPTermResult ) : ?>
              <article>
                <header class="entry-header">
                  <h1 class="entry-title">
                    <a href="<?php echo $post->link; ?>" rel="bookmark"><?php echo $post->taxonomy; ?>: <?php echo $post->name; ?></a>
                  </h1>
                </header><!-- .entry-header -->
                <div class="entry-summary">
                  <p><?php echo $post->description; ?></p>
                </div><!-- .entry-summary -->
              </article>
            <?php else : setup_postdata( $post ); ?>
              <article>
                <header class="entry-header">
                  <h1 class="entry-title">
                    <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
                  </h1>
                </header><!-- .entry-header -->
                <div class="entry-summary">
                  <?php the_excerpt(); ?>
                </div><!-- .entry-summary -->
              </article>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>

      <?php endif; ?>

    </div><!-- #content -->
  </div><!-- #primary -->

<?php
  wp_reset_postdata();
  get_sidebar();
  get_footer();






