<?php
/**
 * Template Name: Content
 * Page content based template file.
 *
 * @package MeineLeberUndIch
 */

get_header();

while (have_posts()) :
    the_post();
    ?>
    <section class="text-gray-700 body-font">
        <div class="container mx-auto flex px-5 py-4 md:flex-row flex-col-reverse items-center">
            <div class=" w-full ">
                <?php the_title('<h1 class="my-5 text-4xl">', '</h1>'); ?>
                <div class="text-start text-justify text-lg">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </section>
<?php
endwhile;

get_footer();