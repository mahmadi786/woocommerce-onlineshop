<?php
/**
 * Add theme dashboard page
 * Get recommended plugins information
 *
 * @return array Plugin slug , active or de-active
 *
 */
function finedine_get_recommended_plugin_info() {

	$recommend_plugins = get_theme_support( 'recommend-plugins' );

	if ( is_array( $recommend_plugins ) && isset( $recommend_plugins[0] ) ) {
		$recommend_plugins = $recommend_plugins[0];
	} else {
		$recommend_plugins[] = array();
	}

	if ( ! empty( $recommend_plugins ) ) {

		$plugin_info_arr = array();
		foreach ( $recommend_plugins as $plugin_slug => $plugin_info ) {

			$plugin_info = wp_parse_args( $plugin_info, array(
				'name'            => '',
				'active_filename' => '',
			) );

			if ( ! empty( $plugin_info['active_filename'] ) ) {
				$plugin_url = $plugin_info['active_filename'];
			} else {
				$plugin_url = $plugin_slug . '/' . $plugin_slug . '.php';
			}
			if ( is_plugin_active( $plugin_url ) ) {
				if ( get_option( $plugin_info['name'] ) !== false ) {
					update_option( $plugin_info['name'], 'active' );
				} else {
					$deprecated = null;
					$autoload   = 'no';
					add_option( $plugin_info['name'], 'active' );
				}
			} else {
				if ( get_option( $plugin_info['name'] ) !== false ) {
					update_option( $plugin_info['name'], 'inactive' );
				} else {
					add_option( $plugin_info['name'], 'inactive' );
				}
			}
			$plugin_info_arr[ $plugin_info['name'] ] = array( get_option( $plugin_info['name'] ), $plugin_slug );
		}

		return $plugin_info_arr;

	}
}

/**
 * Admin notice
 *
 * @return bool
 */
function finedine_admin_notice() {
	if ( ! function_exists( 'finedine_get_recommended_plugin_info' ) ) {
		return false;
	}
	$actions = finedine_get_recommended_plugin_info();

	$theme_data = wp_get_theme();
	?>
	<div class="updated notice notice-success notice-alt is-dismissible">
		<p><?php printf( __( 'Thank you for downloading  %1$s. Please visit our <strong><a href="%2$s">Welcome Page</a></strong>  for how-tos and documentation.', 'finedine' ), esc_html( $theme_data->Name ), esc_url( admin_url( 'themes.php?page=sm_finedine' ) ) ); ?></p>
	</div>
	<?php
}

function finedine_admin_import_notice() {
	?>
	<div class="updated notice notice-success notice-alt is-dismissible">
		<p>
        <?php printf( __( 'To make your transition faster, you can import our <strong><a href="%s">Demo Content</a></strong>.', 'finedine' ), esc_url( admin_url('themes.php?page=sm_finedine&tab=demo-data-importer') ) ); ?>
        </p>
    </div>
	<?php
}

/**
 * Display Notice in admin while activating plugin
 */
function finedine_one_activation_admin_notice() {
	global $pagenow;
	if ( is_admin() && ( 'themes.php' === $pagenow ) && isset( $_GET['activated'] ) ) {
		add_action( 'admin_notices', 'finedine_admin_notice' );
		add_action( 'admin_notices', 'finedine_admin_import_notice' );
	}
}

/* activation notice */
add_action( 'load-themes.php', 'finedine_one_activation_admin_notice' );

/**
 * Display plugin information html
 */
function finedine_get_recommended_plugin_display() {

	$rec_plugins       = finedine_get_recommended_plugin_info();
	$recommend_plugins = get_theme_support( 'recommend-plugins' );

	foreach ( $rec_plugins as $recommended_plugin_name => $plugin_status_slug ) {

		$plugin_name  = $recommended_plugin_name;
		$status       = is_dir( WP_PLUGIN_DIR . '/' . $plugin_status_slug[1] );
		$button_class = 'install-now button';
		if ( $plugin_name ) {
			$active_file_name = $plugin_status_slug[1] . '/wp-' . $plugin_status_slug[1] . '.php';
		}

		if ( ! is_plugin_active( $active_file_name ) ) {
			$button_txt = esc_html__( 'Install Now', 'finedine' );
			if ( ! $status ) {
				$install_url = wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'install-plugin',
							'plugin' => $plugin_status_slug[1],
						),
						network_admin_url( 'update.php' )
					),
					'install-plugin_' . $plugin_status_slug[1]
				);

			} else {
				$install_url  = add_query_arg( array(
					'action'        => 'activate',
					'plugin'        => rawurlencode( $active_file_name ),
					'plugin_status' => 'all',
					'paged'         => '1',
					'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $active_file_name ),
				), network_admin_url( 'plugins.php' ) );
				$button_class = 'activate-now button-primary';
				$button_txt   = esc_html__( 'Active Now', 'finedine' );
			}
		} else {
			echo '<p class="already-activated">' . esc_html( $recommended_plugin_name ) . ' already activated.</p>';
			$button_class = 'activated button-secondary';
			$button_txt   = esc_html__( 'Actived', 'finedine' );
		}
		$plugin_detail_link = add_query_arg(
			array(
				'tab'       => 'plugin-information',
				'plugin'    => $plugin_status_slug[1],
				'TB_iframe' => 'true',
				'width'     => '772',
				'height'    => '349',

			),
			network_admin_url( 'plugin-install.php' )
		);

		echo '<div class="rcp action-item">';
		echo '<h4 class="rcp-name">';
		echo esc_html( $recommended_plugin_name );
		echo '</h4>';
		echo '<p class="action-btn plugin-card-' . esc_attr( $plugin_status_slug[1] ) . '"><a href="' . esc_url( $install_url ) . '" data-slug="' . esc_attr( $plugin_status_slug[1] ) . '" class="' . esc_attr( $button_class ) . '">' . esc_html( $button_txt ) . '</a></p>';
		echo '<a class="plugin-detail thickbox open-plugin-details-modal" href="' . esc_url( $plugin_detail_link ) . '">' . esc_html__( 'Details', 'finedine' ) . '</a>';
		echo '</div>';
	}
}


add_action( 'admin_menu', 'finedine_theme_info' );

/**
 * Theme Info
 */
function finedine_theme_info() {

	if ( 0 === finedine_badge_update_action() ) {
		$badge_update_action = '';
	} else {
		$badge_update_action = finedine_badge_update_action();
	}

	$warning_title       = 'recommended';
	$badge_update_action = finedine_badge_update_action();
	if ( finedine_badge_update_action() > 0 ) {

		$menu_title = sprintf( __( 'Finedine Theme %s ', 'finedine' ), "<span class='update-plugins update-badge count-$badge_update_action' title='$warning_title'><span class='update-count'>" . number_format_i18n( finedine_badge_update_action() ) . "</span></span>" );

	} else {
		$menu_title = sprintf( __( 'Finedine Theme %s', 'finedine' ), "<span class='update-plugins sm-badge opacity-zero update-badge' title=''><span class='update-count'>" . number_format_i18n( finedine_badge_update_action() ) . "</span></span>" );
	}

	add_theme_page( esc_html__( 'finedine Dashboard', 'finedine' ), $menu_title, 'edit_theme_options', 'sm_finedine', 'finedine_theme_info_page' );

}

/**
 * Theme Info Page
 */
function finedine_theme_info_page() {

	$theme_data = wp_get_theme( 'finedine' );

	// Check for current viewing tab.
	$sm_theme_tab = null;
	if ( isset( $_GET['tab'] ) ) {
		$sm_theme_tab = wp_unslash( sanitize_text_field( $_GET['tab'] ) );
	} else {
		$sm_theme_tab = null;
	}

	// Check the eye action in db.
	?>
	<div class="wrap about-wrap theme-detail-wrapper">
		<h1><?php printf( esc_html__( 'Welcome to Finedine - Version %1s', 'finedine' ), esc_html( $theme_data->Version ) ); ?></h1>
		<div class="about-text"><?php esc_html_e( 'Finedine is the perfect theme for hospitality and food websites. If you are building websites for  restaurants, barbecues, grill houses, fast food, pizzerias, resorts, hotels and more, this will be the perfect theme for you. ', 'finedine' ); ?>
		</div>

		<a target="_blank" href="<?php echo esc_url( 'https://www.sampression.com/' ); ?>" class="sampression-logo">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo.png"></a>
		<h2 class="nav-tab-wrapper">
			<a href="?page=sm_finedine"
			   class="nav-tab<?php echo is_null( $sm_theme_tab ) ? ' nav-tab-active' : null; ?>">
				<?php esc_html_e( 'Finedine', 'finedine' ) ?>
			</a>

			<a href="?page=sm_finedine&tab=recommended_actions"
			   class="nav-tab<?php echo $sm_theme_tab == 'recommended_actions' ? ' nav-tab-active' : null; ?>"><?php esc_html_e( 'Recommended Actions', 'finedine' ); ?>

				<?php
				if ( finedine_badge_update_action() != 0 ) {
					?>
					<span class="action-count-show update-badge">
					<?php
					echo esc_html( finedine_badge_update_action() );
					?>
					</span>
					<?php
				} else {
					?>
					<span class="action-count-show update-badge opacity-zero">
					<?php
					echo esc_html( finedine_badge_update_action() );
					?>
					</span>
				<?php }
				?>
			</a>


			<a href="?page=sm_finedine&tab=demo-data-importer"
			   class="nav-tab<?php echo $sm_theme_tab == 'demo-data-importer' ? ' nav-tab-active' : null; ?>"><?php esc_html_e( 'Demo Content', 'finedine' ); ?></span></a>
			<?php do_action( 'finedine_admin_more_tabs' ); ?>
		</h2>

		<?php if ( is_null( $sm_theme_tab ) ) { ?>
			<div class="theme-detail info-tab-content">
				<div class="theme-detail-column clearfix">
					<div class="theme-detail-left">

						<div class="theme-link">
							<h3><?php esc_html_e( 'Theme Customizer', 'finedine' ); ?></h3>
							<p class="about"><?php printf( esc_html__( '%s support Theme Customizer for all theme settings. Lets get started by customize everything from a single place. ', 'finedine' ), esc_html( $theme_data->Name ) ); ?></p>
							<p>
								<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"
								   class="button button-primary"><?php esc_html_e( 'Go to Customizer', 'finedine' ); ?></a>
							</p>
						</div>
						<div class="theme-link">
							<h3><?php esc_html_e( 'Theme Documentation', 'finedine' ); ?></h3>
							<p class="about">
								<?php printf( esc_html__( 'Please visit our', 'finedine' ) ); ?>
								<strong>
									<a href="<?php echo esc_url( 'https://www.sampression.com/documentation-finedine/' ); ?>"
									   target="_blank">
										<?php printf( esc_html__( 'Documentation Section', 'finedine' ) ); ?></a>
								</strong>
								<?php printf( esc_html__( 'for any help on the setup  and configuration process.', 'finedine' ) ); ?>
							<p>
								<a href="<?php echo esc_url( 'https://www.sampression.com/documentation-finedine/' ); ?>"
								   target="_blank"
								   class="button button-secondary"><?php printf( esc_html__( 'Finedine Documentation', 'finedine' ) ); ?></a>
							</p>
							<?php do_action( 'finedine_dashboard_theme_links' ); ?>
						</div>
						<div class="theme-link">
							<h3><?php esc_html_e( 'For Support', 'finedine' ); ?></h3>
							<p class="about"><?php printf( esc_html__( 'We have an active community section where our members can share their experience and knowledge. Also our Sampression Moderator will be happy to answer your questions.', 'finedine' ), esc_html( $theme_data->Name ) ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://www.sampression.com/forums' ); ?>" target="_blank"
								   class="button button-secondary"><?php echo sprintf( esc_html__( 'Visit Our Community Forum', 'finedine' ), esc_html( $theme_data->Name  )  ); ?></a>
							</p>
						</div>
					</div>

					<div class="theme-detail-right">
						<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png" alt="<?php esc_html_e( 'Theme Screenshot', 'finedine' ); ?>"/>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if ( $sm_theme_tab == 'recommended_actions' ) { ?>

			<div class="action-required-tab info-tab-content">
				<?php
				$show_on_front = get_option( 'show_on_front' );
				$page_on_front = get_option( 'page_on_front' );
				$front_pages   = get_pages(
					array(
						'meta_key'   => '_wp_page_template',
						'meta_value' => 'template-restaurant.php'
					)
				);
				?>
				<?php $frontpage_id = "";
				if ( ! empty( $front_pages ) ) {
					$frontpage_id = $front_pages[0]->ID;
				}
				?>
				<div class="sm_theme_link  action-required action-count">
					<?php if ( $show_on_front != 'page' || $frontpage_id != $page_on_front ) { ?>

						<h3 class="section-heading"><?php esc_html_e( 'Set up your homepage displays', 'finedine' ); ?></h3>
						<?php if ( get_option( 'badge_static' ) == '' || get_option( 'badge_static' ) == '0' ) { ?>
							<span class="dashicons  dashicons-visibility badge-static-show"
								  data-id="badge_static_show"></span>
						<?php } else { ?>
							<span class="dashicons dashicons-hidden badge-static-hide"
								  data-id="badge_static_hide"></span>
						<?php } ?>

						<?php if ( $show_on_front !== 'page' && $frontpage_id ) { ?>
							<div class="action-item action-item-1">
								<h3><?php esc_html_e( 'Switch "Your homepage displays" to "A static page".', 'finedine' ); ?></h3>
								<div class="about">
									<p><?php esc_html_e( 'In order to get the Finedine homepage look, please go to Settings -> Reading Settings  and switch "Your homepage displays" to "A static page" and choose "Homepage" form the list of the pages.', 'finedine' ); ?></p>
								</div>
								<p>
									<a href="<?php echo esc_url ( admin_url( 'options-reading.php' ) ); ?>" class="button">
                                        <?php esc_html_e( 'Set Homepage Page Display', 'finedine' ); ?>
                                    </a>
								</p>
							</div>
						<?php } ?>

						<?php if ( $show_on_front !== 'page' && empty( $frontpage_id ) ) { ?>
							<div class="action-item action-item-1">
								<h3><?php esc_html_e( 'Switch "Your homepage displays" to "A static page".', 'finedine' ); ?></h3>
								<div class="about">
									<p><?php esc_html_e( 'In order to get the Finedine homepage look, please go to Settings -> Reading Settings  and switch "Your homepage displays" to "A static page" and choose "Homepage" form the list of the pages.', 'finedine' ); ?></p>
								</div>
								<p>
									<a href="<?php echo esc_url ( admin_url( 'options-reading.php' ) ); ?>"
									   class="button"><?php esc_html_e( 'Set Homepage Page Display', 'finedine' ); ?></a>
								</p>
							</div>
							<div class="action-item action-item-2">
								<h3><?php esc_html_e( 'Set your homepage page template to "Restaurant Template".', 'finedine' ); ?></h3>
								<div class="about">
									<p><?php esc_html_e( 'In order to make the change the content of homepage and  apply our theme demo look, you will need to set template "Restaurant Template" for your homepage.', 'finedine' ); ?></p>
								</div>
								<p>
									<?php
									$front_page = get_option( 'page_on_front' );
									if ( $front_page <= 0 ) {
										?>
										<a href="<?php echo esc_url ( admin_url( 'options-reading.php' ) ); ?>"
										   class="button"><?php esc_html_e( 'Change Homepage Page Template', 'finedine' ); ?></a>
										<?php

									}

									if ( $front_page > 0 && get_post_meta( $front_page, '_wp_page_template', true ) != 'template-frontpage.php' ) {
										?>
										<a href="<?php echo esc_url( get_edit_post_link( $front_page ) ); ?>"
										   class="button"><?php esc_html_e( 'Change Homepage Page Template', 'finedine' ); ?></a>
										<?php
									}
									?>
								</p>
							</div>
						<?php } ?>

						<?php if ( $show_on_front === 'page' && $frontpage_id !== $page_on_front ) { ?>
							<div class="action-item action-item-2">
								<h3><?php esc_html_e( 'Set your homepage page template to "Restaurant Template".', 'finedine' ); ?></h3>
								<div class="about">
									<p><?php esc_html_e( 'In order to make the change the content of homepage and  apply our theme demo look, you will need to set template "Restaurant Template" for your homepage.', 'finedine' ); ?></p>
								</div>
								<p>
									<?php
									$front_page = get_option( 'page_on_front' );
									if ( $front_page <= 0 ) {
										?>
										<a href="<?php echo esc_url ( admin_url( 'options-reading.php' ) ); ?>" class="button"><?php esc_html_e( 'Change Homepage Page Template', 'finedine' ); ?></a>
										<?php
									}
									if ( $front_page > 0 && get_post_meta( $front_page, '_wp_page_template', true ) != 'template-frontpage.php' ) {
										?>
										<a href="<?php echo esc_url( get_edit_post_link( $front_page ) ); ?>"
										   class="button"><?php esc_html_e( 'Change Homepage Page Template', 'finedine' ); ?></a>
										<?php
									}
									?>
								</p>
							</div>
						<?php } ?>

					<?php } else { ?>
						<h3><?php printf( __( 'Keep %s updated', 'finedine' ), esc_html( $theme_data->Name  )  ); ?></h3>
						<p><?php esc_html_e( 'Hooray! There are no required actions for you right now.', 'finedine' ); ?></p>
						<br/>
					<?php } ?>
				</div>
			</div>
		<?php }
		?>

		<?php if ( ! class_exists( 'finedine_Plus' ) ) { ?>
			<?php if ( $sm_theme_tab == 'free_pro' ) { ?>
				<div id="free_pro" class="freepro-tab-content info-tab-content">
					<!--pro vs free -->
					<!--/pro vs free -->
				</div>
			<?php } ?>
		<?php } ?>

		<?php if ( $sm_theme_tab == 'demo-data-importer' ) { ?>
			<div class="demo-import-box info-tab-content">
				<?php
					if (  class_exists( 'OCDI_Plugin' ) ) {
						echo  '<p>' . __( 'One Click Demo Import plugin has already been installed and activated.', 'finedine' ) . '</p>';
						echo  '<p>' . sprintf( __( 'Go to %1$sImport Demo Data%2$s to import demo content.', 'finedine' ), '<a href="' . esc_url( admin_url( '/themes.php?page=pt-one-click-demo-import' ) ) . '">', '</a>' ). '</p>';
					}else{
						echo  '<p>' . sprintf( __( 'Install %1$sOne Click Demo Import%2$s plugin and activate it to import demo content. You can download demo content file from following link. Please make sure plugin is installed and activated. After plugin activation, go to Import Demo Data menu under Appearance and import it.', 'finedine' ), '<a href="' . esc_url( admin_url( '/themes.php?page=tgmpa-install-plugins' ) ) . '">', '</a>' ). '</p>';
						echo  '<p><a href="https://www.sampression.com/themes/finedine/" target="_blank">' . esc_html__( 'Download Demo Content', 'finedine' ) . '</a></p>';
					}
				?>
			</div>
		<?php } ?>

	</div> <!-- END .theme_info -->

	<?php
}
