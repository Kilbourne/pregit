<?php
/**
 * Template Name: Custom Search
 */
?>

  <?php
global $post;
$query = isset( $_GET['searchwpquery'] ) ? sanitize_text_field( $_GET['searchwpquery'] ) : '';
$page = isset( $_GET['swppage'] ) ? absint( $_GET['swppage'] ) : 1;
?>

      <?php if( !empty( $query ) ) : ?>
        <header class="page-header">
          <h1 class="page-title">Search Results for: <?php echo $query; ?></h1>
        </header>
<?php endif; ?>
<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <form role="search" method="get" class="search-form" action="<?php echo get_permalink( 922 ); ?>">
				   <label>
                    <span class="screen-reader-text">' . _x( 'Search for:', 'label' ) . '</span>
                    <input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder' ) . '" value="' . get_search_query() . '" name="swpquery" />
                </label>
                <input type="submit" class="search-submit" value="'. esc_attr_x( 'Search', 'submit button' ) .'" />
            </form>';
  
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>

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
              
              	
			<?php 

$term_id=$post->term->term_id;
	    	$final=get_field('logo', 'producer_'.$term_id)?wp_get_attachment_image(get_field('logo', 'producer_'.$term_id)):wp_get_attachment_image( get_woocommerce_term_meta( $term_id, 'thumbnail_id', true ) );
	    if ( $final ) ?>
	    <div class="entry-summary">
	    <a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>">	
<?php
			echo $final; ?>
		</a>
                  
			  </div><!-- .entry-summary -->
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
              </article>
            <?php else : setup_postdata( $post ); ?>
              <article>
                <div class="search-thumbnail">
    <?php  the_post_thumbnail( 'medium' );  ?>
  </div> 
  <header>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php if (get_post_type() === 'post') { get_template_part('templates/entry-meta'); } ?>
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
              </article>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>

      <?php endif; ?>


<?php
  wp_reset_postdata();

?>
<?php endwhile; ?>

<?php the_posts_navigation(); ?>



     

    
