<?php
	// Fetch valid menu IDs.
	$menu_ids = $this->get_valid_menu_ids( $instance );

	$per_row         = $instance['settings']['per_row'];
	$featured_image  = $instance['settings']['featured_image'];
	$excerpt_length  = $instance['settings']['excerpt_settings']['excerpt_length'];
	$disable_excerpt = $instance['settings']['excerpt_settings']['disable_excerpt'];

	$last_row = floor( ( count( $menu_ids ) - 1 ) / $per_row );
	?>
	<?php if ( ! empty( $instance['title'] ) ) : ?>
 	<?php echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'] ?>
	<?php endif; ?>
	<?php if ( ! empty( $instance['sub_title'] ) ) : ?>
 	<h4 class="widget-sub-title"><?php echo esc_html( $instance['sub_title'] ); ?></h4>
	<?php endif; ?>

<?php if ( ! class_exists( 'Jetpack' ) || ! Jetpack::is_module_active( 'custom-content-types' ) ) : ?>

    <?php if ( current_user_can( 'manage_options' ) ) : ?>
	    <p><?php _e( 'Custom Content Types of Jetpack is not active. Please activate it and enter Food Menus. Then choose Food Menus to be displayed in the widget.', 'restaurantz' ); ?></p>
    <?php else : ?>
    	<p><?php _e( 'No Food Menus found.', 'restaurantz' ); ?>
    <?php endif ?>

<?php else : ?>
	<div class="special-dishes-main special-dishes-column-<?php echo absint( $per_row ); ?>">
		<?php if ( ! empty( $menu_ids ) ) : ?>
			<?php
				$qargs = array(
					'post_type'      => 'nova_menu_item',
					'post__in'       => $menu_ids,
					'orderby'        => 'post__in',
					'posts_per_page' => -1,
					'no_found_rows'  => true,
				);
				$all_posts = get_posts( $qargs );
			?>
			<?php if ( ! empty( $all_posts ) ) : ?>
				<?php foreach ( $all_posts as $i => $post ) : ?>
					<?php if ( 0 === $i % $per_row && 0 !== $i ) : ?>
						<div class="restaurantz-clear"></div>
					<?php endif; ?>

					<div class="special-dishes-item">
						<div class="special-dishes-content">
							<div class="special-dishes-title">
								<h3><a href="<?php echo esc_url( get_permalink( $post->ID ) )?>">
									<?php echo apply_filters( 'the_title', $post->post_title ); ?>
								</a></h3>
							</div><!-- .special-dishes-title -->

							<?php
							$thumb = array();
							if ( 'disable' !== $featured_image && has_post_thumbnail( $post->ID ) ) {
								$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $featured_image );
							}
							?>
							<?php if ( ! empty( $thumb ) ) : ?>
								<div class="special-dishes-thumb">
									<img src="<?php echo esc_url( $thumb[0] ); ?>" alt="<?php echo esc_attr( $post->post_title ); ?>" width="<?php echo esc_attr( $thumb[1] ); ?>" height="<?php echo esc_attr( $thumb[2] ); ?>" />
								</div><!-- .special-dishes-thumb -->
							<?php endif ?>

							<?php
								// Price.
								$price_text = '';
								$price = get_post_meta( $post->ID, 'nova_price', true );
							if ( ! empty( $price ) ) {
								$price_text = esc_html( $price );
							}
								// Category.
								$category_text = '';
								$terms         = wp_get_object_terms( $post->ID, 'nova_menu' );
								$terms_link    = get_term_link( $terms[0]->term_taxonomy_id, 'nova_menu' );

							if ( ! empty( $terms ) ) {
								$category_text = $terms[0]->name;
								$category_url = get_term_link( $terms[0], 'nova_menu' );
							}
							?>
							<?php if ( ! empty( $price_text ) || ! empty( $category_text ) ) : ?>
								<div class="special-dishes-meta">
									<?php if ( ! empty( $price_text ) ) : ?>
										<span class="menu-price"><?php echo $price_text; ?></span>
									<?php endif ?>
									<?php if ( ! empty( $category_text ) ) : ?>
										<a href="<?php echo esc_url( $category_url ); ?>"><span class="menu-category"><?php echo esc_html( $category_text ); ?></span></a>
									<?php endif ?>
								</div><!-- .special-dishes-meta -->
							<?php endif; ?>

						</div><!-- .special-dishes-content -->

						<?php if ( true !== $disable_excerpt ) : ?>
							<div class="special-dishes-excerpt">
								<?php
								$excerpt = restaurantz_the_excerpt( absint( $excerpt_length ), $post );
								echo wp_kses_post( wpautop( $excerpt ) );
								?>
							</div><!-- .special-dishes-excerpt -->
						<?php endif ?>
					</div><!-- .special-dishes-item -->
				<?php endforeach; ?>
			<?php endif; ?>

		<?php else : ?>

			<p><?php _e( 'No Food Menus found.', 'restaurantz' ); ?></p>

		<?php endif ?>
	</div><!-- .special-dishes-main -->
<?php endif;
