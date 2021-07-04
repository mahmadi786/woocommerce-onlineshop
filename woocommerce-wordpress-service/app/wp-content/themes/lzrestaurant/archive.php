<?php
/**
 * The template for displaying archive pages
 * 
 * @subpackage lzrestaurant
 * @since 1.0
 * @version 1.4
 */

get_header(); ?>

<div class="container">
	<?php if ( have_posts() ) : ?>
		<header role="banner" class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header>
	<?php endif; ?>

	<div class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
		    $lzrestaurant_layout_option = get_theme_mod( 'lzrestaurant_theme_options','Right Sidebar');
		    if($lzrestaurant_layout_option == 'Left Sidebar'){ ?>
		    	<div class="row">
		        	<div id="sidebar" class="col-lg-4 col-md-4"><?php dynamic_sidebar('sidebar-1'); ?></div>
			        <div id="" class="content_area col-lg-8 col-md-8">
				    	<section id="post_section" class="">
							<?php
							if ( have_posts() ) : ?>
								<?php
								while ( have_posts() ) : the_post();
									
									get_template_part( 'template-parts/post/content', get_post_format() );

								endwhile;

								else :

									get_template_part( 'template-parts/post/content', 'none' );

								endif; 
							?>
							<div class="navigation">
				                <?php
				                    the_posts_pagination( array(
				                        'prev_text'          => __( 'Previous page', 'lzrestaurant' ),
				                        'next_text'          => __( 'Next page', 'lzrestaurant' ),
				                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'lzrestaurant' ) . ' </span>',
				                    ) );
				                ?>
				                <div class="clearfix"></div>
				            </div>
						</section>
					</div>
				</div>
				<div class="clearfix"></div>
			<?php }else if($lzrestaurant_layout_option == 'Right Sidebar'){ ?>
				<div class="row">
					<div class="content_area col-lg-8 col-md-8">
						<section id="post_section" class="">
							<?php
							if ( have_posts() ) : ?>
								<?php
								while ( have_posts() ) : the_post();

									get_template_part( 'template-parts/post/content', get_post_format() );

								endwhile;

								else :

									get_template_part( 'template-parts/post/content', 'none' );

								endif; 
							?>
							<div class="navigation">
				                <?php
				                    the_posts_pagination( array(
				                        'prev_text'          => __( 'Previous page', 'lzrestaurant' ),
				                        'next_text'          => __( 'Next page', 'lzrestaurant' ),
				                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'lzrestaurant' ) . ' </span>',
				                    ) );
				                ?>
				                <div class="clearfix"></div>
				            </div>
						</section>
					</div>
					<div id="sidebar" class="col-lg-4 col-md-4"><?php dynamic_sidebar('sidebar-1'); ?></div>
				</div>
			<?php }else if($lzrestaurant_layout_option == 'One Column'){ ?>			
				<div class="content_area">
					<section id="post_section" class="">
						<?php
						if ( have_posts() ) : ?>
							<?php
							while ( have_posts() ) : the_post();

								get_template_part( 'template-parts/post/content', get_post_format() );

							endwhile;

							else :

								get_template_part( 'template-parts/post/content', 'none' );

							endif; 
						?>
						<div class="navigation">
			                <?php
			                    the_posts_pagination( array(
			                        'prev_text'          => __( 'Previous page', 'lzrestaurant' ),
			                        'next_text'          => __( 'Next page', 'lzrestaurant' ),
			                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'lzrestaurant' ) . ' </span>',
			                    ) );
			                ?>
			                <div class="clearfix"></div>
			            </div>
					</section>
				</div>
			<?php }else if($lzrestaurant_layout_option == 'Three Columns'){ ?>	
				<div class="row">
					<div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-1'); ?></div>	
					<div id="" class="content_area col-lg-6 col-md-6">
						<section id="post_section" class="">
							<?php
								if ( have_posts() ) : ?>
								<?php
								while ( have_posts() ) : the_post();

									get_template_part( 'template-parts/post/content', get_post_format() );

								endwhile;
								
								else :

									get_template_part( 'template-parts/post/content', 'none' );

								endif;
							?>
							<div class="navigation">
				                <?php
				                    the_posts_pagination( array(
				                        'prev_text'          => __( 'Previous page', 'lzrestaurant' ),
				                        'next_text'          => __( 'Next page', 'lzrestaurant' ),
				                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'lzrestaurant' ) . ' </span>',
				                    ) );
				                ?>
				                <div class="clearfix"></div>
				            </div>
						</section>
					</div>
					<div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-2'); ?></div>
				</div>
			<?php }else if($lzrestaurant_layout_option == 'Four Columns'){ ?>
				<div class="row">
					<div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-1'); ?></div>
					<div id="" class="content_area col-lg-3 col-md-3">
						<section id="post_section" class="">
							<?php
							if ( have_posts() ) : ?>
								<?php
								while ( have_posts() ) : the_post();

									get_template_part( 'template-parts/post/content', get_post_format() );

								endwhile;

								else :

									get_template_part( 'template-parts/post/content', 'none' );

								endif; 
							?>
							<div class="navigation">
				                <?php
				                    the_posts_pagination( array(
				                        'prev_text'          => __( 'Previous page', 'lzrestaurant' ),
				                        'next_text'          => __( 'Next page', 'lzrestaurant' ),
				                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'lzrestaurant' ) . ' </span>',
				                    ) );
				                ?>
				                <div class="clearfix"></div>
				            </div>
						</section>
					</div>
					<div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-2'); ?></div>
			        <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-3'); ?></div>
		        </div>
		    <?php }else if($lzrestaurant_layout_option == 'Grid Layout'){ ?>
		    	<div class="row">
			    	<div id="" class="content_area col-lg-8 col-md-8">
						<section id="post_section" class="">
							<div class="row">
								<?php
								if ( have_posts() ) : ?>
									<?php
									while ( have_posts() ) : the_post();

										get_template_part( 'template-parts/post/grid-layout' );

									endwhile;

									else :

										get_template_part( 'template-parts/post/grid-layout', 'none' );

									endif; 
								?>
								<div class="navigation">
					                <?php
					                    the_posts_pagination( array(
					                        'prev_text'          => __( 'Previous page', 'lzrestaurant' ),
					                        'next_text'          => __( 'Next page', 'lzrestaurant' ),
					                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'lzrestaurant' ) . ' </span>',
					                    ) );
					                ?>
					                <div class="clearfix"></div>
					            </div>
							</div>
						</section>
					</div>
					<div id="sidebar" class="col-lg-4 col-md-4"><?php dynamic_sidebar('sidebar-1'); ?></div>
				</div>	
			<?php }else {?>
				<div class="row">
					<div class="content_area col-lg-8 col-md-8">
						<section id="post_section" class="">
							<?php
							if ( have_posts() ) : ?>
								<?php
								while ( have_posts() ) : the_post();

									get_template_part( 'template-parts/post/content', get_post_format() );

								endwhile;

								else :

									get_template_part( 'template-parts/post/content', 'none' );

								endif; 
							?>
							<div class="navigation">
				                <?php
				                    the_posts_pagination( array(
				                        'prev_text'          => __( 'Previous page', 'lzrestaurant' ),
				                        'next_text'          => __( 'Next page', 'lzrestaurant' ),
				                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'lzrestaurant' ) . ' </span>',
				                    ) );
				                ?>
				                <div class="clearfix"></div>
				            </div>
						</section>
					</div>
					<div id="sidebar" class="col-lg-4 col-md-4"><?php dynamic_sidebar('sidebar-1'); ?></div>
				</div>
			<?php } ?>
		</main>
	</div>
</div>

<?php get_footer();