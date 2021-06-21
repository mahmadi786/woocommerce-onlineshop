<?php
/**
 * The template part for displaying post.
 *
 * @package Food Restaurant 
 * @subpackage food_restaurant
 * @since 1.0
 */
?>
<?php 
  $archive_year  = get_the_time('Y'); 
  $archive_month = get_the_time('m'); 
  $archive_day   = get_the_time('d'); 
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
  <div class="main-inner-ser-box">
    <h2 class="section-title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title();?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2>
    <div class="date-box"><i class="fas fa-calendar-alt"></i><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_html( get_the_date() ); ?><span class="screen-reader-text"><?php echo esc_html( get_the_date() ); ?></span></a></div>
    <div class="box-image">
      <?php 
        if(has_post_thumbnail()) { 
          the_post_thumbnail(); 
        }
      ?>  
    </div>
    <div class="entry-content">
      <?php the_excerpt();?>
    </div>
    <div class="cat-box">
      <i class="fas fa-folder-open"></i><?php the_category(); ?>
    </div>
    <div class="clearfix"></div>
  </div>
</article>