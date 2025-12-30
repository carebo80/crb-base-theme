<?php
if (!defined('ABSPATH')) exit;

$site_name = get_bloginfo('name');
?>

<div class="site-branding flex items-center gap-3 min-w-0">
  <?php if (has_custom_logo()) : ?>
    <div class="site-logo shrink-0">
      <?php the_custom_logo(); ?>
    </div>
  <?php endif; ?>

  <div class="site-title min-w-0">
    <a href="<?php echo esc_url(home_url('/')); ?>"
      class="brand-link block truncate font-bold text-lg"
      aria-label="<?php echo esc_attr($site_name); ?>">
      <?php echo esc_html($site_name); ?>
    </a>
  </div>
</div>
