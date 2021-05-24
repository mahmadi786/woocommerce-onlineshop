<?php
if (get_row_layout() == 'rtl_block') {
    $image_url          = "";
    $is_image_available = false;

    if (trim(get_sub_field('image')) != "") {
        $is_image_available = true;
        $image_url          = get_sub_field('image');
    }
    ?>
    <section class="text-gray-700 body-font <?php if ((get_sub_field('video_id') != 0)) { ?> video-bg <?php } ?>">
        <div class="container <?php if ((get_sub_field('video_id') != 0)) { ?>  video-btn-bg pb-32 <?php } else { ?> pb-10 <?php } ?>
            mx-auto flex px-5 md:px-1 <?php if (is_rtl()) { ?> md:flex-row-reverse <?php } else { ?> md:flex-row <?php } ?>
            flex-col items-center">
            <div class="lg:max-w-lg md:ps-10 lg:ps-10 w-full md:w-1/2 mb-10 md:mb-0">
                <?php if ((get_sub_field('video_id') != 0)) { ?>
                    <div class="flex flex-col items-center mt-10 md:mt-20">
                        <div class="w-full" style="padding:56.25% 0 0 0;position:relative;">
                            <iframe src="https://player.vimeo.com/video/<?php echo get_sub_field('video_id') ?>?title=0&byline=0&portrait=0"
                                    style="position:absolute;top:0;left:0;width:100%;height:100%;"
                                    frameborder="0"
                                    allow="autoplay; fullscreen"
                                    allowfullscreen></iframe>
                        </div>
                        <div style="height: 0px;width: 0px;">
                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/video-bg-bot.png"
                                 class="bot-right">
                        </div>
                    </div>
                <?php } elseif ($is_image_available) { ?>

                    <img class="object-cover object-center rounded" alt="hero" src="<?php echo $image_url; ?>">
                <?php } ?>
            </div>
            <div class="rtl-section block-texts md:pe-10 lg:pe-10 lg:flex-grow md:w-1/2 <?php if (is_rtl()) { ?> xl:pe-24 <?php } else { ?> xl:ps-24 md:ps-12 <?php } ?><?php if ((get_sub_field('video_id') != 0)) { ?> mt-10 md:mt-5 <?php } ?>  flex flex-col text-start items-start">
                <?php if (trim(get_sub_field('title')) != "") { ?>
                    <h1 class="w-full title-font text-start sm:text-4xl text-3xl mb-4 font-bold text-gray-900">
                        <?php echo get_sub_field('title'); ?>
                    </h1>
                <?php }
                if (trim(get_sub_field('secondary_title')) != "") { ?>
                    <h2 class="w-full <?php if(ICL_LANGUAGE_CODE=='ru'){ echo ' russian-font-style ';} ?> title-font text-start sm:text-4xl text-3xl mb-4 font-bold text-gray-900">
                        <?php echo get_sub_field('secondary_title'); ?>
                    </h2>
                <?php }
                if (trim(get_sub_field('text')) != "") { ?>
                    <div class="header-rtl w-full text-start text-justify">
                        <?php echo get_sub_field('text'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php
}