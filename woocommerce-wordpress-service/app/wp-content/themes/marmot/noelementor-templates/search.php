<main class="site-main" role="main">
    <header class="page-header">
        <h1 class="entry-title">
            <?php echo esc_html_x('Search results for: ', 'search results', 'marmot'); ?>
            <span><?php echo get_search_query(); ?></span>
        </h1>
    </header>
    <div class="page-content">
        <?php if (have_posts()) : ?>
            <?php
            while (have_posts()) :
                the_post();
                printf('<h2><a href="%1$s">%2$s</a></h2>', esc_url(get_permalink()), esc_html(get_the_title()));
                the_post_thumbnail();
                the_excerpt();
            endwhile;
            ?>
        <?php else : ?>
            <p><?php esc_html_x('We can\'t find what you\'re looking for.', 'search results', 'marmot'); ?></p>
        <?php endif; ?>
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
