<?php
/**
 * This template display "post cannot be found".
 *
 * @package Food Restaurant
 */
?>
<header role="banner">
	<h2 class="entry-title"><?php esc_html_e( 'Nothing Found', 'food-restaurant' ); ?></h2>
</header>

<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
	<p><?php printf(esc_html__( 'Ready to publish your first post? Get started here.','food-restaurant'), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
<?php elseif ( is_search() ) : ?>
	<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'food-restaurant' ); ?></p><br />
		<?php get_search_form(); ?>
<?php else : ?>
	<p><?php esc_html_e( 'Dont worry it happens to the best of us.', 'food-restaurant' ); ?></p><br />
	<div class="read-moresec">
		<a href="<?php echo esc_url( home_url() ); ?>" class="button hvr-sweep-to-right"><?php esc_html_e( 'Return to Home Page', 'food-restaurant' ); ?><span class="screen-reader-text"><?php esc_html_e( 'Return to home page','food-restaurant' );?></span></a>
	</div>
<?php endif; ?>