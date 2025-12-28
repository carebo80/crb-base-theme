<?php
// src/Walkers/NavWalker.php
if (!defined('ABSPATH')) exit;

class CRB_Nav_Walker extends Walker_Nav_Menu
{

  public function start_lvl(&$output, $depth = 0, $args = null)
  {
    $indent = str_repeat("\t", $depth);

    $output .= "\n$indent<ul
    class=\"sub-menu crb-submenu\"
    x-show=\"open\"
    x-transition
    style=\"display:none;\"
  >\n";
  }

  public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $classes = empty($item->classes) ? [] : (array) $item->classes;
    $has_children = in_array('menu-item-has-children', $classes, true);

    // Give each item a stable key (use ID)
    $key = (int) $item->ID;

    $class_names = join(' ', array_filter($classes));
    $class_attr = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

    // Add Alpine key for items with children
    $alpine_attr = $has_children
      ? ' x-data="{ open:false }" @click.outside="open=false" @keydown.escape.window="open=false"'
      : '';

    $output .= $indent . '<li' . $class_attr . $alpine_attr . '>';

    // Link attributes
    $atts = [];
    $atts['href'] = !empty($item->url) ? $item->url : '';
    $atts['class'] = $depth === 0 ? 'crb-menu-link' : 'crb-submenu-link';

    $attributes = '';
    foreach ($atts as $attr => $value) {
      if ($value === '') continue;
      $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
    }
    $icon = function_exists('get_field') ? get_field('crb_menu_icon', $item) : null;
    $icon_html = '';

    if (!empty($icon) && function_exists('crb_heroicon')) {
      // Desktop + mobile: gleiche Icon-Größe, kannst du pro depth variieren
      $icon_html = '<span class="crb-menu-icon" aria-hidden="true">'
        . crb_heroicon($icon, 'outline', 'h-4 w-4')
        . '</span>';
    }
    // Link text
    $title = apply_filters('the_title', $item->title, $item->ID);

    // Render: link + (optional) toggle
    $output .= '<div class="' . ($depth === 0 ? 'crb-menu-item' : 'crb-submenu-item') . '">';
    $output .= '<a' . $attributes . '>'
      . $icon_html
      . '<span class="crb-menu-label">' . esc_html($title) . '</span>'
      . '</a>';

    if ($has_children) {
      $output .= '
    <button type="button"
      class="crb-submenu-toggle"
      @click.prevent="open = !open"
      :aria-expanded="open ? \'true\' : \'false\'"
      aria-label="' . esc_attr__('Untermenü öffnen', 'crb-base-theme') . '">
      ▾
    </button>
  ';
    }

    $output .= '</div>';

    // IMPORTANT:
    // We don't output the submenu here; WP will call start_lvl() automatically.
    // We just need the submenu UL to react to open state via CSS/Alpine:
    if ($has_children) {
      // We inject an "open state hook" by adding a wrapper div before submenu.
      // But easiest: style .sub-menu with x-show via JS isn't possible from walker.
      // So we'll rely on Alpine directives placed directly on the submenu UL using filter below.
    }
  }

  public function end_el(&$output, $item, $depth = 0, $args = null)
  {
    $output .= "</li>\n";
  }
}
