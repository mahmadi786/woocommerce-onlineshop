<?php
if (get_row_layout() == 'ltr_block') {
    $image_url          = "";
    $is_image_available = false;

    if (trim(get_sub_field('image')) != "") {
        $is_image_available = true;
        $image_url          = get_sub_field('image');
    }

    ?>
    <section class="text-gray-700 body-font">
        <?php
        if (get_row_index() == 1 && (!$is_image_available) && (get_sub_field('video_id') == 0)) {
            ?>
            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/hero-banner.png"
                 class="hero-banner-img">
            <?php
        }
        ?>
        <div class="ltr-block block-texts container mx-auto flex px-5 md:px-1 pt-24 <?php if (is_rtl()) { ?> md:flex-row-reverse <?php } else { ?> md:flex-row <?php } ?> flex-col">
            <div class="ie-block-ltr block-texts md:ps-10 lg:ps-10 <?php if (!$is_image_available && (get_sub_field('video_id') == 0)) { ?> mt-16 <?php } ?> md:mt-0 lg:flex-grow md:w-1/2 <?php if (is_rtl()) { ?> xl:ps-24 <?php } else { ?> xl:pe-24 <?php } ?> flex flex-col md:items-start md:text-start mb:6 md:mb-0">
                <?php if (trim(get_sub_field('title')) != "") { ?>
                    <h1 class="header-rtl header-ltr w-full title-font text-start lg:text-4xl text-3xl mb-4 font-bold text-gray-900">
                        <?php echo get_sub_field('title'); ?>
                    </h1>
                <?php }
                if (trim(get_sub_field('secondary_title')) != "") { ?>
                    <h2 class="header-rtl <?php if(ICL_LANGUAGE_CODE=='ru'){ echo ' russian-font-style ';} ?> header-ltr w-full title-font text-start lg:text-4xl text-2xl mb-4 font-bold text-gray-900">
                        <?php echo get_sub_field('secondary_title'); ?>
                    </h2>
                <?php }
                if (trim(get_sub_field('text')) != "") { ?>
                    <div class="header-ltr w-full text-start text-justify xl:me-10">
                        <?php echo get_sub_field('text'); ?>
                    </div>
                <?php } ?>
            </div>
            <?php if ((get_sub_field('video_id') != 0)) { ?>
                <div class="lg:max-w-lg w-full md:w-1/2">
                    <div class="flex flex-col items-center">
                        <div class="w-full" style="padding:56.25% 0 0 0;position:relative;">
                            <iframe src="https://player.vimeo.com/video/<?php echo get_sub_field('video_id') ?>?title=0&byline=0&portrait=0"
                                    style="position:absolute;top:0;left:0;width:100%;height:100%;"
                                    frameborder="0"
                                    allow="autoplay; fullscreen"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            <?php } elseif ($is_image_available) { ?>
                <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                    <img class="object-cover object-center rounded" src="<?php echo $image_url; ?>">
                </div>
            <?php } else { ?>
                <div class="lg:max-w-lg lg:w-full md:w-1/2 w-1/5">
                </div>
            <?php } ?>
        </div>
    </section>
    <?php
}