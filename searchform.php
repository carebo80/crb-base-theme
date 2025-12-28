<?php
get_template_part('template-parts/search/form', null, [
    'variant'     => 'dropdown',
    'post_type'   => 'product',
    'placeholder' => __('Suche …', 'crb-base-theme'),
]);
