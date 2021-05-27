<div class="restaurantz-cta-base">

	<div class="restaurantz-cta-wrapper">

		<div class="restaurantz-cta-text">
			<?php if ( ! empty( $instance['title'] ) ) : ?>
				<?php echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'] ?>
			<?php endif; ?>
			<?php if ( ! empty( $instance['sub_title'] ) ) : ?>
				<p class="widget-sub-title"><?php echo esc_html( $instance['sub_title'] ); ?></p>
			<?php endif; ?>
		</div>

		<?php $this->sub_widget( 'SiteOrigin_Widget_Button_Widget', $args, $instance['button'] ) ?>

	</div>

</div>
