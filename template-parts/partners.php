<?php
if (!defined('ABSPATH')) exit;

$args = is_array($args ?? null) ? $args : [];

$ids = $args['ids'] ?? array_filter(array_map('absint', explode(',', (string) get_theme_mod('sa_partner_logo_ids', ''))));
$title = $args['title'] ?? __('Unsere Partner', 'crb-base-theme');
$grayscale = array_key_exists('grayscale', $args) ? (bool)$args['grayscale'] : true;

$fallback = ['Partner A', 'Partner B', 'Partner C'];
?>
<section
    id="partners"
    class="logos-section <?php echo $grayscale ? 'is-grayscale' : ''; ?>"
    aria-labelledby="partners-title">
    <div class="container mx-auto px-4">
        <h2 id="partners-title" class="section-title">
            <?php echo esc_html($title); ?>
        </h2>

        <div class="logos-grid">
            <?php foreach ($ids as $id): ?>
                <div class="logo-badge">
                    <?php echo wp_get_attachment_image($id, 'partner_logo', false, [
                        'class'   => 'partner-logo',
                        'loading' => 'lazy',
                    ]); ?>
                </div>
            <?php endforeach; ?>

            <?php if (empty($ids)): ?>
                <?php foreach ($fallback as $name): ?>
                    <div class="logo-badge logo-fallback">
                        <?php echo esc_html($name); ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
