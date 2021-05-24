<?php
if (get_row_layout() == 'full_text_block') {
    ?>
    <section class="text-gray-700 body-font">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-start w-full">
                <?php if (trim(get_sub_field('title')) != "") { ?>
                    <h2 class="title-font text-start lg:text-4xl text-3xl mb-4 font-bold text-gray-900 mb-4">
                        <?php echo get_sub_field('title'); ?>
                    </h2>
                <?php }
                if (trim(get_sub_field('text')) != "") { ?>
                    <div class="w-full mx-auto leading-relaxed text-base text-start block-texts">
                        <?php echo get_sub_field('text'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php
}