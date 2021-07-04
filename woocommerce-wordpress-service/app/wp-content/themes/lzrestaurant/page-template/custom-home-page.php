<?php
/**
 * Template Name: Custom Home
 */

get_header(); ?>

<?php do_action( 'lzrestaurant_above_slider' ); ?>

<?php if( get_theme_mod('lzrestaurant_slider_hide_show') != ''){ ?>
  <section id="slider">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"> 
      <?php $lzrestaurant_slider_pages = array();
        for ( $count = 1; $count <= 4; $count++ ) {
          $mod = intval( get_theme_mod( 'lzrestaurant_slider' . $count ));
          if ( 'page-none-selected' != $mod ) {
            $lzrestaurant_slider_pages[] = $mod;
          }
        }
        if( !empty($lzrestaurant_slider_pages) ) :
          $args = array(
            'post_type' => 'page',
            'post__in' => $lzrestaurant_slider_pages,
            'orderby' => 'post__in'
          );
          $query = new WP_Query( $args );
        if ( $query->have_posts() ) :
          $i = 1;
      ?>     
      <div class="carousel-inner" role="listbox">
        <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
          <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
            <a href="<?php echo esc_url( get_permalink() );?>"><?php the_post_thumbnail(); ?><span class="screen-reader-text"><?php the_title();?></span></a>
            <div class="carousel-caption">
              <div class="inner_carousel">
                <h1><?php the_title();?></h1>
                <p><?php $excerpt = get_the_excerpt(); echo esc_html( lzrestaurant_string_limit_words( $excerpt,20 ) ); ?></p>
                <div class="read-btn">
                  <a href="<?php echo esc_url( get_permalink() );?>" class="blogbutton-small"><?php esc_html_e('READ MORE','lzrestaurant'); ?><span class="screen-reader-text"><?php esc_html_e('READ MORE','lzrestaurant'); ?></span>
                  </a>
                </div>  
              </div>
            </div>
          </div>
        <?php $i++; endwhile; 
        wp_reset_postdata();?>
      </div>
      <?php else : ?>
      <div class="no-postfound"></div>
        <?php endif;
      endif;?>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
        <span class="screen-reader-text"><?php esc_html_e( 'Prev','lzrestaurant' );?></span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
        <span class="screen-reader-text"><?php esc_html_e( 'Next','lzrestaurant' );?></span>
      </a>
    </div>  
    <div class="clearfix"></div>
  </section>
<?php }?>

<?php do_action( 'lzrestaurant_above_product_page' ); ?>

<?php if( get_theme_mod('lzrestaurant_title') != ''){ ?>
  <section id="feature-pro">
  	<div class="container">
      <?php if( get_theme_mod('lzrestaurant_title') != ''){ ?>
      	<p><?php echo esc_html(get_theme_mod('lzrestaurant_title1','')); ?></p>
        <strong><?php echo esc_html(get_theme_mod('lzrestaurant_title','')); ?></strong>
        <img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/border.png'); ?>" alt="<?php esc_attr('Product Title Image','lzrestaurant') ?>">
      <?php }?>

			<?php $lzrestaurant_product_pages = array();
			$mod = intval( get_theme_mod( 'lzrestaurant_product_page' ));
			if ( 'page-none-selected' != $mod ) {
			  $lzrestaurant_product_pages[] = $mod;
			}
		
			if( !empty($lzrestaurant_product_pages) ) :
			  $args = array(
			    'post_type' => 'page',
			    'post__in' => $lzrestaurant_product_pages,
			    'orderby' => 'post__in'
			  );
			  $query = new WP_Query( $args );
			  if ( $query->have_posts() ) :
			    $count = 0;
					while ( $query->have_posts() ) : $query->the_post(); ?>
				    <div class="box-image">
			        <div><?php the_content(); ?></div>
			        <div class="clearfix"></div>
				    </div>
					<?php endwhile; ?>
			  <?php else : ?>
			      <div class="no-postfound"></div>
			  <?php endif;
			endif; 
			wp_reset_postdata(); ?>
  	</div>
  </section>
<?php }?>

<?php do_action( 'lzrestaurant_below_product_page' ); ?>

<div class="container lz-content">
  <?php while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; // end of the loop. ?>
</div>

<?php get_footer(); ?>