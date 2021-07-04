<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="cr-reviews-slider" id="<?php echo $id; ?>" data-slick='<?php echo wp_json_encode( $slider_settings ); ?>' style="<?php echo $section_style; ?>">
	<?php foreach ( $reviews as $i => $review ):
		$rating = intval( get_comment_meta( $review->comment_ID, 'rating', true ) );
		$order_id = intval( get_comment_meta( $review->comment_ID, 'ivole_order', true ) );
		$country = get_comment_meta( $review->comment_ID, 'ivole_country', true );
		$country_code = null;
		if( $country_enabled && is_array( $country ) && isset( $country['code'] ) ) {
			$country_code = $country['code'];
		}
	?>
		<div class="ivole-review-card">
			<div class="cr-review-card-inner" style="<?php echo $card_style; ?>">
				<div class="top-row">
					<div class="rating">
						<div class="crstar-rating" style="<?php echo $stars_style; ?>"><span style="width:<?php echo ($rating / 5) * 100; ?>%;"></span></div>
						<div class="datetime">
							<?php printf( _x( '%s ago', '%s = human-readable time difference', 'customer-reviews-woocommerce' ), human_time_diff( mysql2date( 'U', $review->comment_date, true ), current_time( 'timestamp' ) ) ); ?>
						</div>
					</div>
					<div class="reviewer">
						<div class="reviewer-name">
							<?php
								echo get_comment_author( $review );
								if( $country_code ) {
									echo '<img src="https://www.cusrev.com/flags/' . $country_code . '.svg" class="ivole-grid-country-icon" width="20" height="15" alt="' . $country_code . '">';
								}
							?>
						</div>
						<div class="reviewer-verified">
							<?php echo wc_review_is_from_verified_owner( $review->comment_ID ) ? $verified_text: ''; ?>
						</div>
					</div>
				</div>
				<div class="middle-row">
					<?php
						$avtr = get_avatar( $review->comment_author_email );
						if( $avatars && $avtr ):
					?>
					<div class="review-thumbnail">
						<?php echo $avtr; ?>
					</div>
					<?php
						endif;
					?>
					<div class="review-content">
						<div class="review-text<?php if( ! ( $avatars && $avtr ) ) { echo ' cr-no-avatar'; }; ?>">
            <?php
            $clear_content = wp_strip_all_tags( $review->comment_content );
            if( $max_chars && mb_strlen( $clear_content ) > $max_chars ) {
              $less_content = wp_kses_post( mb_substr( $clear_content, 0, $max_chars ) );
              $more_content = wp_kses_post( mb_substr( $clear_content, $max_chars ) );
              $read_more = '<span class="cr-slider-read-more">...<br><a href="#">' . esc_html__( 'Show More', 'customer-reviews-woocommerce' ) . '</a></span>';
              $more_content = '<div class="cr-slider-details" style="display:none;">' . $more_content . '<br><span class="cr-slider-read-less"><a href="#">' . esc_html__( 'Show Less', 'customer-reviews-woocommerce' ) . '</a></span></div>';
              $comment_content = $less_content . $read_more . $more_content;
              echo $comment_content;
            } else {
            	echo wpautop( wp_kses_post( $review->comment_content ) );
            }
            ?>
            </div>
					</div>
				</div>
				<?php if ( $verified_reviews_enabled && $order_id && intval( $review->comment_post_ID ) !== intval( $shop_page_id ) ): ?>
					<div class="verified-review-row">
						<div class="verified-badge"><?php printf( $badge, $review->comment_post_ID, $order_id ); ?></div>
					</div>
				<?php elseif ( $verified_reviews_enabled && $order_id && intval( $review->comment_post_ID ) === intval( $shop_page_id ) ): ?>
					<div class="verified-review-row">
						<div class="verified-badge"><?php printf( $badge_sr, $order_id ); ?></div>
					</div>
				<?php else: ?>
					<div class="verified-review-row">
						<div class="verified-badge-empty"></div>
					</div>
				<?php endif; ?>
				<?php if ( $show_products && $product = wc_get_product( $review->comment_post_ID ) ):
					if( 'publish' === $product->get_status() ):
				?>
				<div class="review-product" style="<?php echo $product_style; ?>">
					<div class="product-thumbnail">
						<?php echo $product->get_image( 'woocommerce_gallery_thumbnail' ); ?>
					</div>
					<div class="product-title">
						<?php if ( $product_links ): ?>
							<?php echo '<a href="' . esc_url( get_permalink( $product->get_id() ) ) . '">' . $product->get_title() . '</a>'; ?>
						<?php else: ?>
							<?php echo '<span>' . $product->get_title() . '</span>'; ?>
						<?php endif; ?>
					</div>
				</div>
				<?php
					endif;
				endif;
				?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
