<?php

/**
 * Template Name: Front Page
 */
get_header();
?>

<main class="flex-1">
    <?php get_template_part('template-parts/hero'); ?>
    <?php get_template_part('template-parts/features'); ?>
    <?php get_template_part('template-parts/partners', null, [
        'ids' => [91, 87, 91, 87],
        'title' => 'Unsere Partner',
        'grayscale' => true,
    ]); ?>
    <?php get_template_part(
        'template-parts/payments',
        null,
        [
            'ids'       => [92, 89, 237, 238], // deine echten IDs
            'grayscale' => false,
        ]
    ); ?>
</main>

<?php get_footer(); ?>
