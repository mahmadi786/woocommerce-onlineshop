<?php
/**
 * Template file.
 *
 * @package Restaurantz
 */

?>
<div class="section-content section-alignment-<?php echo esc_attr( $instance['align'] ); ?>">
	<?php if ( ! empty( $instance['primary_title'] ) ) : ?>
		<?php echo $args['before_title'] . esc_html( $instance['primary_title'] ) . $args['after_title'] ?>
	<?php endif; ?>

	<?php if ( ! empty( $instance['secondary_title'] ) ) : ?>
		<h4 class="secondary-title"><?php echo esc_html( $instance['secondary_title'] ); ?></h4>
	<?php endif; ?>

	<?php if ( ! empty( $instance['title_content'] ) ) : ?>
		<div class="title-content">
			<?php echo wp_kses_post( wpautop( $instance['title_content'] ) ); ?>
		</div>
	<?php endif; ?>
</div><!-- .section-content -->
