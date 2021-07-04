<?php
/**
 * Template Name: Restaurant Template
 * Restaurant Template With Reservation for our theme
 *
 * @package finedine
 */
get_header();
?>
<?php
// Getting value of customizer.
$slider_post          = ( ( null !== finedine_get_option( 'select_post_feature_slider' ) ) ) ? finedine_get_option( 'select_post_feature_slider' ) : '';
$feature_slider_count = ( ( null !== finedine_get_option( 'feature_slider_count' ) ) ) ? finedine_get_option( 'feature_slider_count' ) : $finedine_array_of_default_settings['feature_slider_count'];
if ( ! empty( $slider_post[0] ) ) {
	?>
	<div class="wow fadeIn hero-slider owl-carousel">
		<?php if ( $slider_post ) { ?>
			<?php
			$args      = array(
				'post_type'      => 'post',
				'cat'            => $slider_post,
				'posts_per_page' => $feature_slider_count,
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					?>
					<?php
					$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
					if ( empty( $featured_img_url ) ) {
						$featured_img_url = get_template_directory_uri() . 'assets/images/hero1.png';
					}
					?>
					<div class="slide"
						 style="background: url(<?php echo esc_url( $featured_img_url ); ?>) no-repeat center center; background-size: cover;">
						<div class="hero-content">
							<h1 class="hero-title">
								<a href="<?php echo esc_url( get_permalink() ); ?>">
									<?php echo esc_html( get_the_title() ); ?>
								</a>
							</h1>
							<?php
							$postinfo = get_post( get_the_ID() );
							if ( '' !== $postinfo->post_excerpt ) {
								$post_excerpt = $postinfo->post_excerpt;
								?>
								<h3 class="hero-sub-title">
									<?php echo esc_html( $post_excerpt ); ?>
								</h3>
							<?php } ?>
						</div>
					</div>

				<?php
				}
				wp_reset_postdata();
			}
		}
		?>
	</div><!-- .hero-slider -->
	<?php
} else {
	?>
	<!--show if slider is not set-->
	<div class="wow fadeIn hero-slider owl-carousel">
		<div class="slide"
			 style="background: url(<?php echo esc_url( get_template_directory_uri() ) . '/assets/images/hero1.jpg'; ?>) no-repeat center center; background-size: cover;">
			<div class="hero-content">
				<h1 class="hero-title"><?php esc_html_e( 'Title', 'finedine' ); ?></h1>
				<h3 class="hero-sub-title"><?php esc_html_e( 'Description', 'finedine' ); ?></h3>
			</div>
		</div>
	</div>
<?php
}
?>

	<div id="content" class="site-content">
	<main id="main" class="site-main">

		<!--show restaurant_widgets_above widget-->
		<?php
		if ( is_active_sidebar( 'finedine-front-widget-1' ) ) {
			dynamic_sidebar( 'finedine-front-widget-1' );

		} else {
			if ( is_customize_preview() ) {
				?>
				<div class="widget-notice"><?php esc_html_e( 'To add a widget, please go to the Widgets > Restaurant Body 1.', 'finedine' ); ?>
					<br>
					<?php esc_html_e( 'Recommended widgets', 'finedine' ); ?>
					<strong><?php esc_html_e( 'SM: Finedine Content Block', 'finedine' ); ?>
					</strong>
				</div>
				<?php
			}
		}
		?>
		<!--end of show restaurant_widgets_above widget-->

		<!--testimonial section-->
		<section class="widget widget-review clearfix wow fadeIn">
			<div class="container">
				<div class="row">
					<h1 class="col-md-12 block-title text-center">
						<?php
						$testimonial_title              = ( ( null !== finedine_get_option( 'section_testimonial_title' ) ) ) ? finedine_get_option( 'section_testimonial_title' ) : '';
						$select_testimonial_pagelist    = ( ( null !== finedine_get_option( 'select_testimonial_pagelist' ) ) ) ? finedine_get_option( 'select_testimonial_pagelist' ) : '';
						$testimonial_image_default      = ( ( null !== finedine_get_option( 'testimonial_image_hide' ) ) ) ? finedine_get_option( 'testimonial_image_hide' ) : 1;
						$section_testimonial_word_limit = ( ( null !== finedine_get_option( 'section_testimonial_word_limit' ) ) ) ? finedine_get_option( 'section_testimonial_word_limit' ) : 25;
						$testimonial_slider_count       = ( ( null !== finedine_get_option( 'testimonial_slider_count' ) ) ) ? finedine_get_option( 'testimonial_slider_count' ) : 5;
						?>
						<?php
						if ( $testimonial_title ) {
							echo esc_html( $testimonial_title );
						} else {
							esc_html_e( 'Reviews and Awards', 'finedine' );
						}
						?>
					</h1>
					<?php
					if ( ! empty( $select_testimonial_pagelist ) ) {
						?>
						<?php
						$args      = array(
							'post_type'      => 'post',
							'cat'            => $select_testimonial_pagelist,
							'posts_per_page' => $testimonial_slider_count,
						);
						$the_query = new WP_Query( $args );
						if ( $the_query->have_posts() ) {
							?>
							<div class="review-slider owl-carousel">
							<?php
							while ( $the_query->have_posts() ) {
								$the_query->the_post();
								?>

								<div class="slide">
									<div class="table-layout">
										<?php
										$testimonial_image       = get_the_post_thumbnail_url( get_the_ID(), 'full' );
										$testimonial_description = get_the_content();
										if ( 0 !== $testimonial_image_default ) {
                                            if ( ! empty( $testimonial_image ) ) {
												?>
                                                <div class="table-cell">
                                                    <img class="aligncenter"
                                                         src="<?php echo esc_url( $testimonial_image ); ?>"
                                                         alt="<?php esc_attr_e( 'testimonial image', 'finedine' ); ?>">
                                                </div>
											<?php
                                            }
											?>
										<?php } ?>
                                        <div class="table-cell <?php if ( $testimonial_image_default == 0 || empty( $testimonial_image ) ) {
											echo 'no-image';
										} ?>">

											<?php if ( ! empty( $testimonial_description ) ) {
												the_content();
											}
											?>
										</div>
										<!-- .table-cell -->
									</div>
									<!-- .table-layout -->
								</div>
							<?php
							}
							wp_reset_postdata();
						}
						?>
						</div><!-- .review-slider -->
						<?php
					}
					?>
				</div><!-- .row -->
			</div><!-- .container -->
		</section>
		<!--end of testimonial section -->

		<!--show restaurant_widgets_below widget-->
		<?php
		if ( is_active_sidebar( 'finedine-front-widget-2' ) ) {
			dynamic_sidebar( 'finedine-front-widget-2' );

		} else {
			if ( is_customize_preview() ) { ?>
				<div class="widget-notice">
					<?php echo wp_kses( __( 'To add a widget, please go to the Widgets > Restaurant Body 2.<br>  Recommended widgets <strong>SM: Finedine Content Block', 'finedine' ),
						array(
							'br'     => array(),
							'strong' => array(),
						)
					);
					?>
				</div>
				<?php
			}
		}
		?>
		<!--end of show restaurant_widgets_below widget-->

		<!--start of widget footer-->
		<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) { ?>
			<aside class="sidebar bottom-widget-area wow fadeIn">
				<div class="container">
					<div class="row">
						<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
					</div>
				</div>
			</aside>
		<?php
		} else {
			if ( is_customize_preview() ) {
				?>
				<div class="widget-notice"><?php esc_html_e( 'To add a widget, please go to the Widgets > Blog Footer.', 'finedine' ); ?>
					<br>
					<?php esc_html_e( 'Recommended widgets', 'finedine' ); ?>
					<strong><?php esc_html_e( 'WordPress Default Widget', 'finedine' ); ?>
					</strong>
				</div>
				<?php
			}
		}
		?>
		<!--end of show restaurant_footer-->

		<!-- reservation footer -->
		<?php
		if ( finedine_get_option( 'hide_reservation_footer_section' ) ) {
			$hide_reservation_footer = finedine_get_option( 'hide_reservation_footer_section' );
		} else {
			$hide_reservation_footer = "";
		}
		if ( $hide_reservation_footer == "0" || $hide_reservation_footer == false ) {
			?>
			<section id="reservation-block" class="reservation-section wow fadeIn">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-lg-2">
							<div class="site-branding">
								<?php
								the_custom_logo();
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
										   rel="home"><?php bloginfo( 'name' ); ?></a>
									</h1>
								<?php
								else :
									?>
									<h1 class="site-title">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
										   rel="home"><?php bloginfo( 'name' ); ?></a>
									</h1>
								<?php
								endif;
								$finedine_description = get_bloginfo( 'description', 'display' );
								if ( $finedine_description || is_customize_preview() ) :
									?>
									<p class="site-description"><?php echo esc_html( $finedine_description ); ?></p>
								<?php endif; ?>
								<span class="slideout-menu-toggle"></span>
							</div>
							<!-- .site-branding -->
							<div class="social-connect">
								<?php
								if ( finedine_get_option( 'finedine_socials_facebook' ) || finedine_get_option( 'finedine_socials_twitter' ) || finedine_get_option( 'finedine_socials_linkedin' ) || finedine_get_option( 'finedine_socials_youtube' )
								) {
									finedine_social_media_icons();
								} else {
									?>
									<a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
									<a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
									<a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
								<?php } ?>
							</div>
							<!-- .social-connect -->
						</div>
						<div class="col-md-12 offset-lg-1 col-lg-6">
							<h1 class="text-center block-heading">
								<?php
								$show_form_title = ( ( null !== finedine_get_option( 'finedine_form_title' ) ) ) ? finedine_get_option( 'finedine_form_title' ) : '';
								if ( false === $show_form_title ) {
									esc_html_e( 'For Reservation', 'finedine' );
								}
								?>
								<?php
								$form_shortcode = finedine_get_option( 'finedine_form_shortcode' );
								?>
								<?php
								if ( $show_form_title ) {
									echo esc_html( $show_form_title );
								}
								?>
							</h1>
							<?php
							if ( $form_shortcode ) {
								echo do_shortcode( $form_shortcode );
							}
							?>
						</div>
						<!-- .reservation-form -->
						<div class="col-md-12 col-lg-3 footer-contact">

							<?php
							$finedine_contact_details_address = ( ( null !== finedine_get_option( 'finedine_contact_details_address' ) ) ) ? finedine_get_option( 'finedine_contact_details_address' ) : '';
							$finedine_contact_details_phone   = ( ( null !== finedine_get_option( 'finedine_contact_details_phone' ) ) ) ? finedine_get_option( 'finedine_contact_details_phone' ) : '';
							$finedine_contact_details_fax     = ( ( null !== finedine_get_option( 'finedine_contact_details_fax' ) ) ) ? finedine_get_option( 'finedine_contact_details_fax' ) : '';
							$finedine_contact_details_email   = ( ( null !== finedine_get_option( 'finedine_contact_details_email' ) ) ) ? finedine_get_option( 'finedine_contact_details_email' ) : '';

							if ( $finedine_contact_details_address ) {
								?>
								<div class="footer-address">
									<?php if ( ! empty( $finedine_contact_details_address ) ) { ?>
										<p><?php echo esc_html( $finedine_contact_details_address ); ?></p>
									<?php } ?>
									<?php if ( ! empty( $finedine_contact_details_phone ) ) { ?>
									<p><?php esc_html_e( 'Phone:', 'finedine' ); ?>
                                        <?php echo esc_html( $finedine_contact_details_phone ); ?>
										<?php } ?>
										<?php if ( ! empty( $finedine_contact_details_fax ) ){ ?>
										<br/><?php esc_html_e( 'Fax:', 'finedine' ); ?>
                                        <?php echo esc_html( $finedine_contact_details_fax ); ?>
									</p>
								<?php } ?>
									<?php if ( ! empty( $finedine_contact_details_email ) ) { ?>
										<p><?php esc_html_e( 'Need Help? Send us an email', 'finedine' ); ?> <br>
											<a href="<?php echo esc_url( 'mailto:' . $finedine_contact_details_email ); ?>">
												<?php echo esc_html( $finedine_contact_details_email ); ?>
											</a>
										</p>
									<?php } ?>
								</div>
							<?php
							} else {
								?>
								<div class="footer-address">
									<div class="widget-notice">
										<p><?php esc_html_e( 'Add contact details from footer option', 'finedine' ); ?></p>
									</div>
								</div>
							<?php } ?>

						</div>
						<!-- .footer-contact -->

					</div>
					<!-- .row -->
				</div>
				<!-- .container -->
			</section>

		<?php } ?>
		<!-- end of reservation footer -->

	</main>
	<!-- #main -->

<?php
get_footer();
