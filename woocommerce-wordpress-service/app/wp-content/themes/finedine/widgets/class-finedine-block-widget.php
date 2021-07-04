<?php
/**
 * Extend of Core WP_Widget class used to implement a frontend widget.
 *
 * @since 1.0
 *
 * @see   WP_Widget
 *
 */
if ( ! class_exists( 'Finedine_Block_Widget' ) ) :

	/**
	 * Featured Block widget class.
	 *
	 * @since 1.0.0
	 */
	class Finedine_Block_Widget extends WP_Widget {
		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			$widget_ops = array(
				'classname'   => 'feature-block-widget',
				'description' => esc_html__( 'Contains Text, Image & Button', 'finedine' ),
			);
			parent::__construct( 'Finedine_Block_Widget', __( 'SM: Finedine Content Block', 'finedine' ), $widget_ops );

		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$title              = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$description        = ! empty( $instance['description'] ) ? ( $instance['description'] ) : '';
			$sm_button_text     = ! empty( $instance['sm_button_text'] ) ? ( $instance['sm_button_text'] ) : '';
			$image_align        = ! empty( $instance['image_align'] ) ? ( $instance['image_align'] ) : '';
			$sm_button_text_url = ! empty( $instance['sm_button_text_url'] ) ? ( $instance['sm_button_text_url'] ) : '';
			$image_uri          = ! empty( $instance['image_uri'] ) ? ( $instance['image_uri'] ) : '';
			$block_type         = ! empty( $instance['block_type'] ) ? ( $instance['block_type'] ) : '';
			$subtitle           = ! empty( $instance['subtitle'] ) ? ( $instance['subtitle'] ) : '';

			echo $args['before_widget'];
			?>

			<?php if ( 'featured' === $block_type ) { ?>
                <section class="widget widget-featured-block clearfix ">
                    <div class="layout-style1">
                        <div class="container-fullwidth">
                            <div class="row">
								<?php
								if ( 'left' === $image_align ) {
									?>
                                    <div class="col-md-6 equal-col background-holder wow fadeInRight"
                                         style="background: url(<?php echo esc_url( $instance['image_uri'] ); ?>) center center no-repeat; background-size: cover;"
                                         data-wow-offset="10">
                                    </div>
                                    <div class="col-md-6 equal-col wow fadeIn fadeInUp"
                                         data-wow-offset="10">
                                    <div class="intro-inner">
									<?php
									if ( ! empty( $title ) ) {
										?>
                                        <h1><?php echo esc_html( $title ); ?></h1>
										<?php
									}
									?>
									<?php
									if ( ! empty( $description ) ) {
										echo esc_html( $description );
									}
									if ( ! empty( $sm_button_text ) ) {
										?>
                                        <div class="btn-group clearfix">
                                            <a href="<?php
											if ( ! empty( $sm_button_text_url ) ) {
												echo esc_url( $sm_button_text_url );
											}
											?>" class="btn btn-primary">
												<?php
												if ( ! empty( $sm_button_text ) ) {
													echo esc_attr( $sm_button_text );
												}
												?>
                                            </a>
                                        </div>

                                        </div>
                                        </div>

										<?php
									}
								}
								if ( $image_align == "right" ) {
									?>
                                    <div class="col-md-6 equal-col wow fadeIn fadeInUp"
                                         data-wow-offset="10">
                                        <div class="intro-inner">
											<?php
											if ( ! empty( $title ) ) {
												?>
                                                <h1><?php echo esc_attr( $title ); ?></h1>
												<?php
											}
											?>
											<?php
											if ( ! empty( $description ) ) {
												echo esc_html( $description );
											}
											if ( ! empty( $sm_button_text ) ) {
												?>
                                                <div class="btn-group clearfix">
                                                    <a href="<?php
													if ( ! empty( $sm_button_text_url ) ) {
														echo esc_attr( $sm_button_text_url );
													}
													?>" class="btn btn-primary">
														<?php
														if ( ! empty( $sm_button_text ) ) {
															echo esc_attr( $sm_button_text );
														}
														?>
                                                    </a>
                                                </div>
											<?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 equal-col background-holder wow fadeInLeft"
                                         style="background: url(<?php echo esc_url( $image_uri ); ?>) center center no-repeat; background-size: cover;"
                                         data-wow-offset="10">
                                    </div>
								<?php }
								?>
                            </div><!-- .row -->
                        </div><!-- .container -->
                    </div><!-- .layout-style1 -->
                </section>
			<?php } ?>

			<?php if ( $block_type == "cfa" ) {
				if ( ! empty( $image_uri ) ) { ?>
                    <section class="widget widget-cfa clearfix">
                        <div class="layout-style2"
                             style="background: url(<?php echo esc_url( $image_uri ); ?>?>) center center no-repeat; background-size: cover;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 text-center">
										<?php if ( ! empty( $title ) ) { ?><h1
                                                class="wow fadeInUp"><?php echo esc_html( $title ); ?></h1><?php } ?>
										<?php if ( ! empty( $subtitle ) ) { ?>
                                            <h2 class="section-heading wow fadeInUp"><?php echo esc_html( $subtitle ); ?></h2><?php } ?>
										<?php if ( ! empty( $sm_button_text ) ) { ?>
                                            <a href="<?php echo esc_url( $sm_button_text_url ); ?>"
                                               class="btn btn-tertiary wow fadeInUp"><?php echo esc_attr( $sm_button_text ); ?></a><?php } ?>
                                    </div><!-- .col-md-12 -->
                                </div><!-- .row -->
                            </div><!-- .container -->
                        </div><!-- .layout-style1 -->
                    </section>

				<?php }
			} ?>

			<?php
			echo $args['after_widget'];
		}

		/**
		 * Update widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $new_instance New settings for this instance as input by the user via
		 *                            {@see WP_Widget::form()}.
		 * @param array $old_instance Old settings for this instance.
		 *
		 * @return array Settings to save or bool false to cancel saving.
		 */
		function update( $new_instance, $old_instance ) {

			$instance = $old_instance;

			$instance['title'] = sanitize_text_field( $new_instance['title'] );

			$instance['description'] = sanitize_text_field( $new_instance['description'] );

			$instance['sm_button_text'] = sanitize_text_field( $new_instance['sm_button_text'] );

			$instance['sm_button_text_url'] = esc_url_raw( $new_instance['sm_button_text_url'] );

			$instance['image_uri'] = esc_url_raw( $new_instance['image_uri'] );

			$instance['image_align'] = sanitize_text_field( $new_instance['image_align'] );

			$instance['block_type'] = sanitize_text_field( $new_instance['block_type'] );

			$instance['subtitle'] = sanitize_text_field( $new_instance['subtitle'] );

			return $instance;

		}

		/**
		 * Output the settings update form.
		 *
		 * @since 1.0.0
		 *
		 * @param array $instance Current settings.
		 */
		function form( $instance ) {
			wp_enqueue_script( 'finedine-widget-script' );
			$title          = ! empty( $instance['title'] ) ? ( $instance['title'] ) : '';
			$subtitle       = ! empty( $instance['descriptions'] ) ? ( $instance['descriptions'] ) : '';
			$sm_button_text = ! empty( $instance['sm_button_text'] ) ? ( $instance['sm_button_text'] ) : '';
			$image_uri      = ! empty( $instance['image_uri'] ) ? ( $instance['image_uri'] ) : '';
			$block_type     = ! empty( $instance['block_type'] ) ? ( $instance['block_type'] ) : '';
			$image_align    = ! empty( $instance['image_align'] ) ? ( $instance['image_align'] ) : '';
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'block_type' ) ); ?>">
                    <?php esc_html_e( 'Block Type', 'finedine' ); ?>
                </label>
                    <div class="block-sample">
                        <img class="cfa-sample" src="<?php echo esc_url( get_template_directory_uri() ) . '/customizer/images/icon-cfa.png'; ?>">
                        <img class="feature-sample" src="<?php echo esc_url( get_template_directory_uri() ) . '/customizer/images/icon-featured.png'; ?>">
                    </div>
            </p>
            <p>
                <select class="block-type" id="<?php echo esc_attr( $this->get_field_id( 'block_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'block_type' ) ); ?>">
					<option value=""><?php esc_html_e( 'Select Block Type', 'finedine' ); ?></option>
					<option value="featured" <?php selected( $block_type, 'featured' ); ?>><?php esc_html_e( 'Featured', 'finedine' ); ?></option>
					<option value="cfa" <?php selected( $block_type, 'cfa' ); ?>><?php esc_html_e( 'Call For Action', 'finedine' ); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'image_uri' ) ); ?>"><?php esc_html_e( 'Image',
						'finedine' ); ?></label>
                <img class="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>_media_image custom_media_image"
                     src="<?php if ( ! empty( $image_uri ) ) {
					     echo esc_url( $image_uri );
				     } ?>"/>
                <input input type="hidden" type="text"
                       class="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>_media_id custom_media_id"
                       name="<?php echo esc_attr( $this->get_field_name( 'image_id' ) ); ?>"
                       id="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>"
                       value=""/>
                <input type="text"
                       class="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>_media_url custom_media_url"
                       name="<?php echo esc_attr( $this->get_field_name( 'image_uri' ) ); ?>"
                       id="<?php echo esc_url( $this->get_field_id( 'image_uri' ) ); ?>"
                       value="<?php echo esc_url( $image_uri ); ?>">
            </p>
            <p>
                <input type="button" value="Upload Image"
                       class="button custom_media_upload"
                       id="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:',
						'finedine' ); ?></label>
                <input class="widefat"
                       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                       type="text"
                       value="<?php if ( ! empty( $instance['title'] ) ) {
					       echo esc_html( $instance['title'] );
				       } ?>"/>
            </p>
            <p class="cfa-wid">
                <label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_html_e( 'CFA Description:',
						'finedine' ); ?></label>
                <input class="widefat"
                       id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>"
                       type="text"
                       value="<?php if ( ! empty( $instance['subtitle'] ) ) {
					       echo esc_html( $instance['subtitle'] );
				       } ?>"/>
            </p>

            <p class="feature-wid">
                <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Short Description:',
						'finedine' ); ?></label>
                <input type="text" class="widefat"
                       id="<?php echo esc_html( $this->get_field_id( 'description' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"
                       value="<?php if ( ! empty( $instance['description'] ) ) {
					       echo esc_attr( $instance['description'] );
				       } ?>">
            </p>
            <p class="feature-wid">
                <label for="<?php echo esc_attr( $this->get_field_id( 'image_align' ) ); ?>"><?php esc_html_e( 'Image Alignment:', 'finedine' ); ?></label>
				<select class="feature"id="<?php echo esc_attr( $this->get_field_id( 'image_align' ) ); ?>"name="<?php echo esc_attr( $this->get_field_name( 'image_align' ) ); ?>">
					<option value="right" <?php selected( $image_align, 'right' ); ?>><?php esc_html_e( 'Right', 'finedine' ); ?></option>
					<option value="left" <?php selected( $image_align, 'left' ); ?>><?php esc_html_e( 'Left', 'finedine' ); ?></option>
				</select>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'sm_button_text' ) ); ?>"><?php esc_html_e( 'Button Text',
						'finedine' ); ?></label>
                <input type="text" class="widefat"
                       id="<?php echo esc_attr( $this->get_field_id( 'sm_button_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'sm_button_text' ) ); ?>"
                       value="<?php if ( ! empty( $instance['sm_button_text'] ) ) {
					       echo esc_attr( $instance['sm_button_text'] );
				       } ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'sm_button_text_url' ) ); ?>"><?php esc_html_e( 'Button URL',
						'finedine' ); ?></label>
                <input type="text" class="widefat"
                       id="<?php echo esc_attr( $this->get_field_id( 'sm_button_text_url' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'sm_button_text_url' ) ); ?>"
                       value="<?php if ( ! empty( $instance['sm_button_text_url'] ) ) {
					       echo esc_url( $instance['sm_button_text_url'] );
				       } ?>">
            </p>
			<?php
		}

	}
endif;

/**
 * register featured block widget
 *
 */
function feature_block_register_widgets() {
	register_widget( 'Finedine_Block_Widget' );
}

add_action( 'widgets_init', 'feature_block_register_widgets' );
