<?php get_header(); ?>
    <div class="kt-main" role="main">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-8">
                <?php if(have_posts()):while(have_posts()):the_post(); ?>
                    <div <?php post_class('kt-article');?>>
                        <div class="row">
                            <div class="col-md-1 nopadding">
                                <div class="kt-article-date">
                                    <div class="the_date">
                                    <span class="day"><?php the_time('d');?></span>
                                    <span class="month_year"><?php the_time('M');
                                    echo ', ';
                                    the_time('Y');?></span>
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- Main Blog Post -->
                                <div class="col-md-11">
                             
                                <a href="<?php the_permalink(); ?>">
                                    <?php 
                                        if(has_post_thumbnail()): the_post_thumbnail(); endif;
                                    ?>
                                </a>
                              
                                <!-- Blog Post Title -->
                                <h1>
                                <a class="kt-article-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php
                                $thetitle = get_the_title($post->ID);
                                $origpostdate = get_the_date('M d, Y', $post->post_parent);
                                if($thetitle == null):echo $origpostdate; 
                                else:
                                the_title();
                                endif;
                                ?>
                                </a>
                                </h1>    
                                <!-- Blog Post Title ends here -->
                               
                                <!-- Blog Post Meta -->
                                <div class="kt-article-meta">
                                <span><?php echo __('by','businesscard'); ?> <?php echo get_the_author(); ?></span>
                                  | <span><?php the_time(get_option('date_format')); ?></span>
                                </div>
                                <!-- Blog Post Meta ends here -->
                                
                                <!-- Blog Post Categories and Comments -->
                                <div class="kt-article-categories">
                                    <span><i class="icon_comment_alt"> </i><?php comments_number( __('No Comments','businesscard'), __('1 Comment','businesscard'),__('% Comment' ,'businesscard')); ?></span>
                                    <span class="post-categories"><i class="icon_tag_alt"></i>
                                    <?php echo get_the_category_list(','); ?>
                                    </span>
                                </div>
                                <!-- Blog Post Categories and Comments ends here -->
                                
                                <!-- Blog Post Main Content/Excerpt -->
                                <div class="kt-article-content">
                                    <?php the_excerpt(); ?>
                                </div>
                                <!-- Blog Post Main Content/Excerpt ends -->
                                </div>
                            <!-- Main Blog Post Ends -->
                        </div>
                    </div>
                <?php endwhile; endif;?>
                <div id="kt-pagination">
                    <div class="alignleft">
                        <?php previous_posts_link(__( '&laquo; Newer posts', 'businesscard')); ?>
                    </div>
                    <div class="alignright">
                        <?php next_posts_link(__( 'Older posts &raquo;', 'businesscard')); ?>
                    </div>
                </div>
                </div>
                <!-- Sidebar -->
                <div class="col-md-4">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>