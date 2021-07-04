<?php

if (is_singular()) {
    get_template_part('noelementor-templates/single');
} elseif (is_archive() || is_home()) {
    get_template_part('noelementor-templates/archive');
} elseif (is_search()) {
    get_template_part('noelementor-templates/search');
} else {
    get_template_part('noelementor-templates/404');
}
