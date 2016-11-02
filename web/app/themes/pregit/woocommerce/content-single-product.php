<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
	 global $post;
	 $post_id=$post->ID;
	 
	 $p_cat = array_values(array_map (function($v){ return $v->slug; },array_filter(get_the_terms( $post_id, 'product_cat' ),function($el){
	 		return $el->parent === 0;
	 })))[0];	 
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php wc_get_template( 'single-product/title.php' ); ?>
<div class="first-col">
	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>	
	<?php
		$producer_terms=wp_get_post_terms(get_the_id(), 'producer', array("fields" => "ids"));
		
	 if($producer_terms) { 
	 	$term_id = $producer_terms[0];
	 	?>
	<div class="produttore-link">
		<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>">
			<p><?php _e('Guarda tutti i prodotti','sage') ?></p>
			<?php echo wp_get_attachment_image(get_field('logo', 'producer_'.$term_id))?wp_get_attachment_image(get_field('logo', 'producer_'.$term_id)):''; ?>
		</a>
	</div>
	<?php } 
		if(get_field('scheda_prodotto',get_the_id())){
			

	 ?>
	<div class="product-scheda">
		<a href="<?php echo wp_get_attachment_url(get_field('scheda_prodotto',get_the_id()));  ?>" ><?php _e('Scarica la scheda','sage') ?> </a>
	</div>
	<?php } ?>
</div>
 <div class="second-col">
   <div class="first-row-container">
    <div class="tabella-attributi">
    	<?php 
    		$b_att = ['denominazione','classificazione','alcol','annata'];
    		$c_att = ['provenienza'];
    		$arr_att = $p_cat === 'bevande' ? $b_att : $c_att ;
    		foreach ($arr_att as $key => $value) {
    			$field = get_field_object($value);
    			echo '<p class="riga-attributo"><span class="titolo">'. __($field['label'],'sage') . '</span><span class="attributo">'. $field['value'].'</span></p>';
    		}
    		if($producer_terms) { 
    	 ?> 		
 		 <p class="riga-attributo"><span class="titolo"><?php _e('Produttore','sage') ?>  </span><span class="attributo"><?php echo get_term( $term_id, 'producer' )->name  ?></span></p> 
<?php 
}
global $product;
if($product->is_type( 'variable' )){
$get_variations = sizeof( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

			$available_variations = $get_variations ? $product->get_available_variations() : false;
			$attributes           = $product->get_variation_attributes();
			$selected_attributes  = $product->get_variation_default_attributes();
			$attribute_keys = array_keys( $attributes );
		 ?>
 		 	<?php  if ( !empty( $available_variations )) {  ?>
<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr class="riga-attributo">
						<td class="label titolo"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
						<td class="value">
							<?php
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $product->get_variation_default_attribute( $attribute_name );
								wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
								echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . __( 'Clear', 'woocommerce' ) . '</a>' ) : '';
							?>
						</td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
		<?php }} ?>
 	</div>
 	<div class="buy-container">
 	<?php do_action( 'woocommerce_single_product_summary' );
?>	
 	</div>
 	<?php  		if( $p_cat !== 'bevande'){
 			echo '<div class="product-notes attributo-espanso-content">'.get_field( 'note', $post_id  ).'</div>';
 		} ?>
   </div>
 	<div class="attributi-espansi">
 	<?php 
 		$b_att = ['caratteristiche_organolettiche','abbinamenti','temperatura_di_servizio','vinificazione',];
    		$c_att = ['descrizione_prodotto','allergeni','utilizzo_e_abbinamento','processo_produttivo',];
    		$arr_att = $p_cat === 'bevande' ? $b_att : $c_att ;
    		$obj_arr = array_map(function($el){
    			$field = get_field_object($el);
    			return [ "label"=>$field['label'], "value" => $field['value'] ];
    		},$arr_att);    		
 	 ?>
 	 	<div class="prima-riga">
 	 		<?php if($obj_arr[0]['value'] && $obj_arr[0]['value'] !== ''){ ?>
 	 		<div class="colonna-left">
 	 		
 	 			<div class="organolettiche"><h4 class="attributo-espanso-title"><?php _e($obj_arr[0]['label'],'sage'); ?> </h4>
 	 			<div class="attributo-espanso-content"><?php echo $obj_arr[0]['value'];?></div> </div>
 	 			
 	 		</div>
 	 		<?php } ?>
 	 		<?php if(($obj_arr[1]['value'] && $obj_arr[1]['value'] !== '' ) || ($obj_arr[2]['value'] && $obj_arr[2]['value'] !== '') ) { ?>
 	 		<div class="colonna-right">
				<?php if($obj_arr[1]['value'] && $obj_arr[1]['value'] !== ''){ ?>
 	 			<div class="abbinamenti"><h4 class="attributo-espanso-title"><?php _e($obj_arr[1]['label'],'sage'); ?> </h4>
 	 			<div class="attributo-espanso-content"><?php echo $obj_arr[1]['value'];?></div> </div>
<?php } ?>
<?php if($obj_arr[2]['value'] && $obj_arr[2]['value'] !== ''){ ?>
 	 			<div class="temperatura"><h4 class="attributo-espanso-title"><?php _e($obj_arr[2]['label'],'sage'); ?> </h4>
 	 			<div class="attributo-espanso-content"><?php echo $obj_arr[2]['value'];?></div> </div>
<?php } ?>
 	 		</div>
 	 		<?php } ?>
 	 	</div>
 	 	<?php if($obj_arr[3]['value'] && $obj_arr[3]['value'] !== ''){ ?>
 	 	<div class="secondariga">

 	 		<div class="vinificazione"><h4 class="attributo-espanso-title"><?php _e($obj_arr[3]['label'],'sage'); ?> </h4>
 	 		<div class="attributo-espanso-content"><?php echo $obj_arr[3]['value'];?></div> </div>

 	 	</div>
 	 	<?php } ?>
 	 </div> 
 </div> 
 <section class="product-form">
<div class="product-form-wrapper"> 
<div class="caption"><h3 class="product-form-title"><?php _e('RICHIEDI INFORMAZIONI SUL PRODOTTO','sage'); ?> </h3><p class="product-form-subtitle"><?php _e('Sarai ricontattato da un nostro consulente nel più breve tempo possibile.','sage') ;?> </p></div> 
	<?php echo do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]' ); ?> </div> 
	</section>



	<!--<div class="summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			! * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			! * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			
		?>

	</div>--><!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
