<?php
/**
 * Template Name: Page
 * Page template file.
 *
 * @package MeineLeberUndIch
 */

get_header();

if (have_rows('module')) {
    while (have_rows('module')) {
        the_row();
        get_template_part('acf/' . get_row_layout());
    }
}

get_footer();