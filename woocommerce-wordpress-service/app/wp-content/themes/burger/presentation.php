<?php
/*
* Template Name: Presentation
*/
get_header(); 
if(have_posts()):while(have_posts()):the_post(); 

    the_content(); 

wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'burger' ) . '</span>', 'after' => '</div>' ) );
?>
<div class="clearfix"></div>
<?php 
endwhile ; endif; 
get_footer(); 
?>