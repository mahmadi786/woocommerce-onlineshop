<?php get_header(); ?>
<div class="kt-main" role="main">
     <div class="container">
         <div class="row">
         <!-- Main Content -->
         <div class="col-md-8">
         <?php if(have_posts()):while(have_posts()):the_post(); ?>
         <div <?php post_class('kt-article'); ?>>
         <div class="row">
         
         <!-- Main Blog Post -->
         <div class="col-md-11 col-sm-10 col-xs-10">
             <?php 
             if(has_post_thumbnail()): the_post_thumbnail('blog-listing-img'); endif;
             ?>           
        
         <!-- Blog Post Title -->
         <h1>
         
             <?php 
             $thetitle = get_the_title($post->ID);
             $origpostdate = get_the_date(get_option('date_format'), $post->post_parent);
             if($thetitle == null):echo $origpostdate; 
             else:
             the_title();
             endif;
             ?>
         
         </h1>    
         <!-- Blog Post Title ends here -->
        
         <!-- Blog Post Main Content/Excerpt -->
         <div class="kt-article-content">
         <?php the_content(); ?>
         </div>
         <?php if(has_tag()):?>
             <div class="kt-article-tags">
             <?php       
             echo get_the_tag_list('<p><i class="icon_tag_alt"></i>'.__(' Tags: ','burger').' ',', ','</p>');
             ?>
             </div>
         <?php endif; ?>
         <!-- Blog Post Main Content/Excerpt ends -->
         </div>
         <!-- Main Blog Post Ends -->
         </div>
         </div>
         <?php endwhile; endif;?>
         
         <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'burger' ) . '</span>', 'after' => '</div>' ) ); ?>
         <div class="kt-divider clearfix"></div>
         
         <div class="row">
                        <div class="col-md-12">
                            <div id="kt-comments">
                                <?php comments_template( '', true ); ?>
                            </div>
                        </div>
         </div>
         
         
         </div>
         <!-- Sidebar -->
         <div class="col-md-offset-1 col-md-3">
         <?php get_sidebar(); ?>
         </div>
         </div>
     </div>
 </div><!-- Main Ends Here -->
<?php get_footer(); ?>