<?php
/**
 * The left sidebar widget area.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */
?>

<div id="secondary">

	<?php do_action( 'foodhunt_before_sidebar' ); ?>

	<?php if( ! dynamic_sidebar( 'foodhunt_left_sidebar' ) ) :

		the_widget( 'WP_Widget_Text',
			array(
				'title'  => esc_html__( 'Example Widget', 'foodhunt' ),
				'text'   => sprintf( esc_html__( 'This is an example widget to show how the Left Sidebar looks by default. You can add custom widgets from the %swidgets screen%s in the admin. If custom widgets is added than this will be replaced by those widgets.', 'foodhunt' ), current_user_can( 'edit_theme_options' ) ? '<a href="' . admin_url( 'widgets.php' ) . '">' : '', current_user_can( 'edit_theme_options' ) ? '</a>' : '' ),
				'filter' => true,
			),
			array(
				'before_widget' => '<aside class="widget widget_text clearfix">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title"><span>',
				'after_title'   => '</span></h4>'
			)
		);
	endif; ?>

	<?php do_action( 'foodhunt_after_sidebar' ); ?>
</div>
