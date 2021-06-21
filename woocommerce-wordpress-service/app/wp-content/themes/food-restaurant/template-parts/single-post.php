<?php
/**
 * The template part for displaying single post.
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
<article> 
	<h1><?php the_title();?></h1>
	<div class="metabox">
		<span class="entry-date"><i class="far fa-calendar-alt"></i><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_html( get_the_date() ); ?><span class="screen-reader-text"><?php echo esc_html( get_the_date() ); ?></span></a></span>
		<span class="entry-author"><i class="fas fa-user"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><?php the_author(); ?><span class="screen-reader-text"><?php the_author(); ?></span></a></span>
		<span class="entry-comments"><i class="far fa-comments"></i><?php comments_number( __('0 Comment', 'food-restaurant'), __('0 Comments', 'food-restaurant'), __('% Comments', 'food-restaurant') ); ?> </span>
	</div>
	<?php if(has_post_thumbnail()) { ?>
		<hr>
		<div class="feature-box">	
			<?php the_post_thumbnail(); ?>
		</div>
		<hr>					
	<?php } ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<div class="post-tags">
		<?php
        if( $tags = get_the_tags() ) {
          foreach( $tags as $content_tag ) {
            $sep = ( $content_tag === end( $tags ) ) ? '' : ' ';
            echo '<a href="' . esc_url(get_term_link( $content_tag, $content_tag->taxonomy )) . '">' . esc_html($content_tag->name) . '</a>' . esc_html($sep);
            }
        } ?>
	</div> 
	<?php
	wp_link_pages( array(
		'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'food-restaurant' ) . '</span>',
		'after'       => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
		'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'food-restaurant' ) . ' </span>%',
		'separator'   => '<span class="screen-reader-text">, </span>',
	) );
		
	if ( is_singular( 'attachment' ) ) {
		// Parent post navigation.
		the_post_navigation( array(
			'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'food-restaurant' ),
		) );
	} elseif ( is_singular( 'post' ) ) {
		// Previous/next post navigation.
		the_post_navigation( array(
			'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'food-restaurant' ) . '</span> ' .
				'<span class="screen-reader-text">' . __( 'Next post:', 'food-restaurant' ) . '</span> ' .
				'',
			'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'food-restaurant' ) . '</span> ' .
				'<span class="screen-reader-text">' . __( 'Previous post:', 'food-restaurant' ) . '</span> ' .
				'',
		) );
	}

	echo '<div class="clearfix"></div>';

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
	?>
	<?php edit_post_link( __( 'Edit', 'food-restaurant' ), '<span class="edit-link">', '</span>' ); ?>
</article>