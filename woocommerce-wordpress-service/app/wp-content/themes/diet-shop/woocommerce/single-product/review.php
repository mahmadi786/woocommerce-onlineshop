<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 5.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">


<div id="comment-<?php comment_ID(); ?>" class="single-comment clearfix comment_container">
     <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, 80,'','', array('class' => 'float-left') ); ?>
    <div class="comment float-left">
        <h6><?php echo get_comment_author_link();?>
        
        <?php
		
		/**
			 * The woocommerce_review_before_comment_meta hook.
			 *
			 * @hooked woocommerce_review_display_rating - 10
			 */
			do_action( 'woocommerce_review_before_comment_meta', $comment );
		?>
        </h6>
        <div class="date"> 
            <?php
                /* translators: 1: date, 2: time */
                printf( esc_html__('%1$s at %2$s', 'diet-shop' ), get_comment_date(),  get_comment_time() ); 
            ?>
        </div>
       
        <div class="comment-text"><?php 
			do_action( 'woocommerce_review_before_comment_text', $comment );
			/**
			 * The woocommerce_review_comment_text hook
			 *
			 * @hooked woocommerce_review_display_comment_text - 10
			 */
			do_action( 'woocommerce_review_comment_text', $comment );
			do_action( 'woocommerce_review_after_comment_text', $comment );
		
		?></div>
    </div>
</div>
<div class="clearfix"></div>

            
</li>
