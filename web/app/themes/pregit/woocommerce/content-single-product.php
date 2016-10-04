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
	<div class="produttore-link">
		<a href="">
			<p><?php _e('Guarda tutti i prodotti','sage') ?></p>
			<img src="" alt="">
		</a>
	</div>
	<div class="product-scheda">
		<a href="" "<?php _e('Scarica la scheda','sage') ?> "><?php _e('Scarica la scheda','sage') ?> </a>
	</div>
</div>
 <div class="second-col">
   <div class="first-row-container">
    <div class="tabella-attributi">
 		<p class="riga-attributo"><span class="titolo"><?php _e('Denominazione','sage') ?>  </span><span class="attributo"><?php echo get_field( 'denominazione', $post_id  ); ?></span></p>
 		 <p class="riga-attributo"><span class="titolo"><?php _e('Classificazione','sage') ?>  </span><span class="attributo"><?php echo get_field( 'classificazione', $post_id  ); ?></span></p>
 		 <p class="riga-attributo"><span class="titolo"><?php _e('Alcol Vol. %','sage') ?>  </span><span class="attributo"><?php echo get_field( 'alcol', $post_id  ); ?></span></p>
 		 <p class="riga-attributo"><span class="titolo"><?php _e('Annata','sage') ?>  </span><span class="attributo"><?php echo get_field( 'annata', $post_id  ); ?></span></p>
 		 <p class="riga-attributo"><span class="titolo"><?php _e('Produttore','sage') ?>  </span><span class="attributo"><?php echo get_field( 'produttore2', $post_id  ); ?></span></p> 
 	</div>
 	<div class="buy-container">
 	<?php  woocommerce_template_single_price(); woocommerce_template_single_add_to_cart() ?>	
 	</div>
 	
   </div>
 	<div class="attributi-espansi">
 	 	<div class="prima-riga">
 	 		<div class="colonna-left">
 	 			<div class="organolettiche"><h4 class="attributo-espanso-title"><?php _e('CARATTERISTICHE ORGANOLETTICHE','sage'); ?> </h4>
 	 			<div class="attributo-espanso-content"><?php echo get_field( 'caratteristiche_organolettiche', $post_id  );?></div> </div>
 	 		</div>
 	 		<div class="colonna-right">
 	 			<div class="abbinamenti"><h4 class="attributo-espanso-title"><?php _e('ABBINAMENTI','sage'); ?> </h4>
 	 			<div class="attributo-espanso-content"><?php echo get_field( 'abbinamenti', $post_id  );?></div> </div>
 	 			<div class="temperatura"><h4 class="attributo-espanso-title"><?php _e('TEMPERATURA DI SERVIZIO °C','sage'); ?> </h4>
 	 			<div class="attributo-espanso-content"><?php echo get_field('temperatura_di_servizio',  $post_id  );?></div> </div>
 	 		</div>
 	 	</div>
 	 	<div class="secondariga">
 	 		<div class="vinificazione"><h4 class="attributo-espanso-title"><?php _e('VINIFICAZIONE','sage'); ?> </h4>
 	 		<div class="attributo-espanso-content"><?php echo get_field('vinificazione',  $post_id  );?></div> </div>
 	 	</div>
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
		//do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
