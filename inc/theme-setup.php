<?php
if (!defined('ABSPATH')) exit;

add_filter('body_class', function ($classes) {

  // outline on/off
  $outline = get_theme_mod('crb_icon_button_outline', true);
  $classes[] = $outline ? 'icon-btn--outline' : 'icon-btn--ghost';

  // size sm/md/lg
  $size = get_theme_mod('crb_icon_button_size', 'md');
  if (!in_array($size, ['sm', 'md', 'lg'], true)) $size = 'md';
  $classes[] = 'icon-btn-size-' . $size;

  return $classes;
});
add_action('after_setup_theme', function () {
  add_theme_support('custom-logo', [
    'height'      => 80,
    'width'       => 240,
    'flex-height' => true,
    'flex-width'  => true,
  ]);
});
