<?php

/**
 * Products Strip (parametrierbar)
 *
 * Usage:
 * get_template_part('template-parts/sections/products-strip', null, [
 *   'title'       => 'Beliebt im Shop',
 *   'source'      => 'featured', // featured|category|ids|latest|sale
 *   'limit'       => 8,
 *   'category'    => 'aktionen', // slug, nur bei category
 *   'ids'         => [12,34,56], // nur bei ids
 *   'orderby'     => 'date',     // z.B. date|title|rand|menu_order
 *   'order'       => 'DESC',     // ASC|DESC
 *   'columns'     => 4,          // 2..6
 *   'show_price'  => true,
 *   'show_cart'   => true,
 *   'show_link'   => true,
 *   'link_label'  => 'Alle Produkte',
 * ]);
 */

if (!defined('ABSPATH')) exit;
if (!class_exists('WooCommerce')) return;

// ---------- Args ----------
$title      = $args['title']      ?? __('Produkte', 'crb-base-theme');
$source     = $args['source']     ?? 'featured';
$limit      = max(1, (int)($args['limit'] ?? 8));
$columns    = (int)($args['columns'] ?? 4);
$columns    = max(2, min(6, $columns));

$show_price = isset($args['show_price']) ? (bool)$args['show_price'] : true;
$show_cart  = isset($args['show_cart'])  ? (bool)$args['show_cart']  : true;
$show_link  = isset($args['show_link'])  ? (bool)$args['show_link']  : true;

$link_label = $args['link_label'] ?? __('Alle Produkte', 'crb-base-theme');

$orderby    = $args['orderby'] ?? 'date';
$order      = strtoupper($args['order'] ?? 'DESC');
$order      = in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC';

$category   = $args['category'] ?? '';    // slug
$ids        = $args['ids'] ?? [];         // array<int>

// Shop URL
$shop_id  = function_exists('wc_get_page_id') ? wc_get_page_id('shop') : 0;
$shop_url = $shop_id > 0 ? get_permalink($shop_id) : home_url('/');

// container
$container = $args['container'] ?? 'default';
$container_cls = match ($container) {
  'full' => 'w-full px-3 sm:px-4 md:px-6 lg:px-8',
  'wide' => 'max-w-7xl mx-auto px-4',
  default => 'crb-container px-4',
};

// ---------- Query base ----------
$q_args = [
  'post_type'           => 'product',
  'posts_per_page'      => $limit,
  'post_status'         => 'publish',
  'ignore_sticky_posts' => true,
  'orderby'             => $orderby,
  'order'               => $order,
];

// ---------- Source handling ----------
switch ($source) {
  case 'featured':
    $q_args['tax_query'] = [[
      'taxonomy' => 'product_visibility',
      'field'    => 'name',
      'terms'    => ['featured'],
    ]];
    break;

  case 'category':
    if ($category !== '') {
      $q_args['tax_query'] = [[
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => [$category],
      ]];
    }
    break;

  case 'ids':
    if (is_string($ids)) {
      // erlaubt auch "12,34,56"
      $ids = array_filter(array_map('absint', explode(',', $ids)));
    }
    if (is_array($ids) && !empty($ids)) {
      $q_args['post__in'] = array_map('absint', $ids);
      $q_args['orderby']  = 'post__in'; // Reihenfolge wie angegeben
    } else {
      return;
    }
    break;

  case 'sale':
    // Sale-Produkte: WC liefert IDs
    if (function_exists('wc_get_product_ids_on_sale')) {
      $sale_ids = wc_get_product_ids_on_sale();
      $sale_ids = array_filter(array_map('absint', $sale_ids));
      if (empty($sale_ids)) return;
      $q_args['post__in'] = $sale_ids;
      // orderby bleibt wie gesetzt
    } else {
      return;
    }
    break;

  case 'latest':
  default:
    // latest = Standard date DESC
    $q_args['orderby'] = 'date';
    $q_args['order']   = 'DESC';
    break;
}

$q = new WP_Query($q_args);
if (!$q->have_posts()) return;

// ---------- Grid classes ----------
$grid_cls = match ($columns) {
  2 => 'grid gap-4 sm:grid-cols-2',
  3 => 'grid gap-4 sm:grid-cols-2 lg:grid-cols-3',
  4 => 'grid gap-4 sm:grid-cols-2 lg:grid-cols-4',
  5 => 'grid gap-4 sm:grid-cols-2 lg:grid-cols-5',
  6 => 'grid gap-4 sm:grid-cols-2 lg:grid-cols-6',
  default => 'grid gap-4 sm:grid-cols-2 lg:grid-cols-4',
};
?>

<section class="py-10">
  <div class="<?php echo esc_attr($container_cls); ?>">
    <div class="flex items-end justify-between gap-4 mb-4">
      <h2 class="section-title m-0"><?php echo esc_html($title); ?></h2>

      <?php if ($show_link): ?>
        <a class="btn-outline" href="<?php echo esc_url($shop_url); ?>">
          <?php echo esc_html($link_label); ?>
        </a>
      <?php endif; ?>
    </div>

    <div class="<?php echo esc_attr($grid_cls); ?>">
      <?php while ($q->have_posts()): $q->the_post();
        global $product; ?>
        <?php if (!$product) continue; ?>

        <article class="crb-card crb-card--hover p-4">
          <a href="<?php the_permalink(); ?>" class="block">
            <div class="aspect-square overflow-hidden rounded-xl"
              style="background-color: var(--c-surface-2);">
              <?php
              echo $product->get_image(
                'woocommerce_thumbnail',
                ['class' => 'w-full h-full object-contain p-3']
              );
              ?>
            </div>

            <div class="mt-3">
              <div class="font-semibold leading-snug">
                <?php the_title(); ?>
              </div>

              <?php if ($show_price): ?>
                <div class="crb-muted text-sm mt-1">
                  <?php echo wp_kses_post($product->get_price_html()); ?>
                </div>
              <?php endif; ?>
            </div>
          </a>

          <?php if ($show_cart): ?>
            <div class="mt-3">
              <?php woocommerce_template_loop_add_to_cart(); ?>
            </div>
          <?php endif; ?>
        </article>

      <?php endwhile;
      wp_reset_postdata(); ?>
    </div>
  </div>
</section>
