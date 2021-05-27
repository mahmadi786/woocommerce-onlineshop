<div class="contact-main-wrapper">
	<?php
	if ( ! empty( $instance['title'] ) ) : ?>
	<?php echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'] ?>
	<?php endif; ?>
	<?php if ( ! empty( $instance['sub_title'] ) ) : ?>
		<h4 class="widget-sub-title"><?php echo esc_html( $instance['sub_title'] ); ?></h4>
	<?php endif; ?>
	<?php
	if ( ! empty( $instance['address_repeater'] ) ) : ?>
		<div class="contact-main-details">
			<?php foreach ( $instance['address_repeater'] as $item ) : ?>
			 	<div class="quick-contact-wrapper">
					<?php if ( ! empty( $item['icon'] ) ) : ?>
						<div class="contact-icon">
							<?php echo siteorigin_widget_get_icon( $item['icon'] );?>
						</div>
					<?php endif; ?>
					<div class="contact-info-wrapper">
					<?php if ( ! empty( $item['contact'] ) ) : ?>
						<strong class="contact-type">
							<?php echo esc_attr( $item['contact'] );	?>
						</strong>
					<?php endif; ?>
					<?php if ( ! empty( $item['contact_detail'] ) ) : ?>
						<span class="contact-detail">
							<?php echo esc_attr( $item['contact_detail'] );?>
						</span>
					<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
