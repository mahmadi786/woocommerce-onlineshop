<?php
/**
 * Displaying all single posts.
 *
 * @package Food Restaurant
 */

get_header(); ?>

<?php do_action( 'food_restaurant_single_header' ); ?>

<main id="main" role="main">
	<div class="container">
	    <div class="middle-align">
		    <?php
	        $food_restaurant_layout = get_theme_mod( 'food_restaurant_theme_options','Right Sidebar');
	        if($food_restaurant_layout == 'Left Sidebar'){?>
		        <div class="row">
			        <div class="col-lg-4 col-md-4" id="sidebar"><?php dynamic_sidebar('sidebar-1'); ?></div>
					<div class="col-lg-8 col-md-8" id="content-lt">
						<?php while ( have_posts() ) : the_post(); 
							get_template_part( 'template-parts/single-post' );
			            endwhile; // end of the loop. ?>
			       	</div>
			    </div>
	       	<?php }else if($food_restaurant_layout == 'Right Sidebar'){?>
	       		<div class="row">
			       	<div class="col-lg-8 col-md-8" id="content-lt">
						<?php while ( have_posts() ) : the_post(); 
							get_template_part( 'template-parts/single-post' );
			            endwhile; // end of the loop. ?>
			       	</div>
					<div class="col-lg-4 col-md-4" id="sidebar"><?php dynamic_sidebar('sidebar-1'); ?></div>
				</div>
			<?php }else if($food_restaurant_layout == 'One Column'){?>
		       	<div id="content-lt">
					<?php while ( have_posts() ) : the_post(); 
						get_template_part( 'template-parts/single-post' );
		            endwhile; // end of the loop. ?>
		       	</div>
		    <?php }else if($food_restaurant_layout == 'Three Columns'){?>
		    	<div class="row">
			    	<div class="col-lg-3 col-md-3" id="sidebar"><?php dynamic_sidebar('sidebar-1'); ?></div>
			       	<div class="col-lg-6 col-md-6" id="content-lt">
						<?php while ( have_posts() ) : the_post(); 
							get_template_part( 'template-parts/single-post' );
			            endwhile; // end of the loop. ?>
			       	</div>
					<div class="col-lg-3 col-md-3" id="sidebar"><?php dynamic_sidebar('sidebar-1'); ?></div>
				</div>
			<?php }else if($food_restaurant_layout == 'Four Columns'){?>
				<div class="row">
			    	<div class="col-lg-3 col-md-3" id="sidebar"><?php dynamic_sidebar('sidebar-2'); ?></div>
			       	<div class="col-lg-3 col-md-3" id="content-lt">
						<?php while ( have_posts() ) : the_post(); 
							get_template_part( 'template-parts/single-post' );
			            endwhile; // end of the loop. ?>
			       	</div>
					<div class="col-lg-3 col-md-3" id="sidebar"><?php dynamic_sidebar('sidebar-2'); ?></div>
					<div class="col-lg-3 col-md-3" id="sidebar"><?php dynamic_sidebar('sidebar-3'); ?></div>
				</div>
			<?php }else if($food_restaurant_layout == 'Grid Layout'){?>
				<div class="row">
			       	<div class="col-lg-8 col-md-8" id="content-lt">
						<?php while ( have_posts() ) : the_post(); 
							get_template_part( 'template-parts/single-post' );
			            endwhile; // end of the loop. ?>
			       	</div>
					<div class="col-lg-4 col-md-4" id="sidebar"><?php dynamic_sidebar('sidebar-1'); ?></div>
				</div>
			<?php }else {?>
				<div class="row">
			       	<div class="col-lg-8 col-md-8" id="content-lt">
						<?php while ( have_posts() ) : the_post(); 
							get_template_part( 'template-parts/single-post' );
			            endwhile; // end of the loop. ?>
			       	</div>
					<div class="col-lg-4 col-md-4" id="sidebar"><?php dynamic_sidebar('sidebar-1'); ?></div>
				</div>
			<?php } ?>
	        <div class="clearfix"></div>
	    </div>
	</div>
</main>	

<?php do_action( 'food_restaurant_single_footer' ); ?>

<?php get_footer(); ?>