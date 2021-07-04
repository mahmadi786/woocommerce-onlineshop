<?php
while (have_posts()) : the_post();
    ?>

    <main <?php post_class('site-main'); ?> role="main">
        <div class="content-box">
            <header class="page-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header>

            <div class="page-content">
                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail();
                }
                ?>

                <?php if (is_single()): ?>
                    <div class="post-meta">
                        <div><?php echo esc_html_x('By', 'posts archive', 'marmot'); ?> <?php the_author(); ?></div>
                        <div><?php the_date() ?> <?php the_time() ?></div>
                        <div><?php echo esc_html_x('Category:', 'posts archive', 'marmot'); ?> <?php the_category(', ') ?></div>
                    </div>
                <?php endif; ?>

                <?php the_content(); ?>
                <div class="clearfix"></div>
                <div class="post-tags">
                    <?php the_tags('<span class="tag-links">' . _x('Tagged ', 'single post', 'marmot'), null, '</span>'); ?>
                </div>

                <?php wp_link_pages(); ?>
            </div>

            <?php
            if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) {
                comments_template();
            }
            ?>
        </div>
    </main>

    <?php
endwhile;
