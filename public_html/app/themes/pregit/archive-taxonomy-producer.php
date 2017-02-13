<?php
/**
 * Template Name: Archive Taxonomy Producer
 */
?>

<div class="producers-wrapper">
<?php
	$args=[
		 'taxonomy'=>'producer'
	];
	$terms=get_terms($args);
	if($terms){
?>

 	<ul class="producers-list">
<?php
	foreach ($terms as $key => $term) {
		$term_id=$term->term_id;
?>
<li class="term-producer">
<h2 hidden><?php the_title(); ?></h2>
<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>">
			<?php echo wp_get_attachment_image(get_field('logo', 'producer_'.$term_id))?wp_get_attachment_image(get_field('logo', 'producer_'.$term_id)):''; ?>
		</a>
</li>
<?php
	}
?>
   	</ul>
<?php 	} ?>
</div>
