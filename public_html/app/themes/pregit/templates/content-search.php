<article <?php post_class(); ?>>
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
