<?php
/**
 * Template file.
 *
 * @package Restaurantz
 */

?>
	<?php if ( ! empty( $instance['title'] ) ) : ?>
		<?php echo $args['before_title']; ?> <?php echo esc_html( $instance['title'] ); ?> <?php echo $args['after_title']; ?>
	<?php endif; ?>

	<?php if ( ! empty( $instance['subtitle'] ) ) : ?>
		<h4 class="widget-sub-title"><?php echo esc_html( $instance['subtitle'] ); ?></h4>
	<?php endif; ?>
	<?php
	if ( has_nav_menu( 'social' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'social',
			'container'      => false,
			'depth'          => 1,
			'link_before'    => '<span class="screen-reader-text">',
			'link_after'     => '</span>',
		) );
	}

