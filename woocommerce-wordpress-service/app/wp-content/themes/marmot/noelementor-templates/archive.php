<main class="site-main" role="main">

    <header class="page-header">
        <?php
        the_archive_title('<h1 class="entry-title">', '</h1>');
        the_archive_description('<p class="archive-description">', '</p>');
        ?>
    </header>

    <div class="page-content">
        <?php
        while (have_posts()) {
            the_post();
            $post_link = get_permalink();
            ?>
            <article class="post content-box">
                <?php
                if (has_post_thumbnail($post)) {
                    printf('<a href="%1$s">%2$s</a>', esc_url($post_link), get_the_post_thumbnail($post, 'large'));
                }
                printf('<h3 class="%1$s"><a href="%2$s">%3$s</a></h3>', 'entry-title', esc_url($post_link), esc_html(get_the_title()));
                the_excerpt();
                ?>
                <div class="post-meta">
                    <div><?php echo esc_html_x('By', 'posts archive', 'marmot'); ?> <?php the_author(); ?></div>
                    <div><?php the_date() ?> <?php the_time() ?></div>
                    <div><?php echo esc_html_x('Category:', 'posts archive', 'marmot'); ?> <?php the_category(', ') ?></div>
                </div>
                <?php printf('<a href="%1$s" class="read-more">%2$s</a>', esc_url($post_link), esc_html_x('Read more', 'posts archive', 'marmot')); ?>
            </article>
        <?php } ?>
    </div>

    <?php wp_link_pages(); ?>

    <?php
    global $wp_query;
    if ($wp_query->max_num_pages > 1) :
        ?>
        <nav class="pagination" role="navigation">
            <div class="nav-previous"><?php
                /* translators: %s: archive navigation */
                next_posts_link(sprintf(_x('%1$s older', 'posts archive', 'marmot'), '<span class="meta-nav">&larr;</span>'));
                ?></div>
            <div class="nav-next"><?php
                /* translators: %s: archive navigation */
                previous_posts_link(sprintf(_x('newer %1$s', 'posts archive', 'marmot'), '<span class="meta-nav">&rarr;</span>'));
                ?></div>
        </nav>
    <?php endif; ?>
</main>
