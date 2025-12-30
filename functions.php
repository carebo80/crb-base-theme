<?php
if (!defined('ABSPATH')) exit;

define('CRB_BASE_THEME_VERSION', '0.1.0');
define('CRB_BASE_THEME_DIR', get_template_directory());
define('CRB_BASE_THEME_URI', get_template_directory_uri());

require_once CRB_BASE_THEME_DIR . '/inc/icons.php';
require_once CRB_BASE_THEME_DIR . '/inc/helpers.php';
require_once CRB_BASE_THEME_DIR . '/inc/customizer.php';
require_once CRB_BASE_THEME_DIR . '/inc/theme-setup.php';
require_once CRB_BASE_THEME_DIR . '/inc/offline.php';
require_once CRB_BASE_THEME_DIR . '/src/Walkers/NavWalker.php';


add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'primary' => __('Primary Menu', 'crb-base-theme'),
    ]);
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('crb-base-theme', CRB_BASE_THEME_URI . '/assets/dist/main.css', [], CRB_BASE_THEME_VERSION);

    wp_enqueue_script('crb-header', CRB_BASE_THEME_URI . '/assets/js/header.js', [], CRB_BASE_THEME_VERSION, true);
    wp_script_add_data('crb-header', 'defer', true);

    wp_enqueue_script('alpinejs', 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js', ['crb-header'], null, true);
    wp_script_add_data('alpinejs', 'defer', true);

    wp_enqueue_script('preline', 'https://cdn.jsdelivr.net/npm/preline@2.4.1/dist/preline.min.js', ['alpinejs'], null, true);
    wp_script_add_data('preline', 'defer', true);
});
