<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package finedine
 */

get_header();
$page_post_id = get_option( 'page_for_posts' );
if (  has_custom_header() ) {
  	?>
	<div class="interior-hero">
		<?php the_custom_header_markup(); 
		?>
		<div class="title-wrap">
			<h1 class="page-title">
				<?php echo esc_html(get_the_title(absint($page_post_id)));?>
			</h1>
		</div>
	</div>
	<?php }else{?>
		<div class="interior-hero">
			<img src="<?php echo esc_url(get_template_directory_uri());?>/assets/images/hero1.jpg" alt="<?php  esc_attr_e('header img','finedine');?>">
			<div class="title-wrap">
				<h1 class="page-title">
					<?php 
					if( is_home() && $page_post_id != 0 ){
						echo esc_html( get_the_title(absint($page_post_id) ) );
					}else{
						echo esc_html__('Blog', 'finedine');
					}
					?></h1>
			</div>
		</div>
	<?php } ?>

	<div id="content" class="site-content">
	<div class="container clear ">
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				<div class="row">

						<?php
						if ( have_posts() ) :

							if ( is_home() && ! is_front_page() ) :
								?>
								<header>
									<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
								</header>
								<?php
							endif;

							/* Start the Loop */
							while ( have_posts() ) :
								the_post();

								/*
                                 * Include the Post-Type-specific template for the content.
                                 * If you want to override this in a child theme, then include a file
                                 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                                 */
								get_template_part( 'template-parts/content', 'list' );
								endwhile;
								the_posts_pagination();
						else :

							get_template_part( 'template-parts/content', 'none' );

						endif;
						?>

				</div>

			</main><!-- #main -->

		</div><!-- #primary -->

	</div><!-- .container -->
</div><!-- #content -->
<!--start of widget footer-->
<?php
if ( is_active_sidebar( 'footer-sidebar-1' ) ) :
?>
<aside class="sidebar bottom-widget-area wow fadeIn">
    <div class="container">
        <div class="row">
            <!--show restaurant_footer-->
            <?php
                dynamic_sidebar( 'footer-sidebar-1' );
            ?>
        <!--end of show restaurant_footer-->
        </div>
    </div>
</aside>
<?php
endif;
?>
<!--end of show restaurant_footer-->
<?php
get_footer();
