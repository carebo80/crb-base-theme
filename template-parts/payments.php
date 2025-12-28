<?php

/**
 * Payments / Zahlungsmöglichkeiten
 * Args: ids(array), title(string), grayscale(bool)
 */

$ids       = $args['ids'] ?? [];
$title     = $args['title'] ?? __('Zahlungsmöglichkeiten', 'crb-base-theme');
$grayscale = array_key_exists('grayscale', $args) ? (bool) $args['grayscale'] : false;

// Fallback wenn leer
$fallback = ['Visa', 'Mastercard', 'TWINT', 'Rechnung'];
?>

<section
    id="payments"
    class="logos-section <?php echo $grayscale ? 'is-grayscale' : ''; ?>"
    aria-labelledby="payments-title">

    <div class="container mx-auto px-4">

        <h2 id="payments-title" class="section-title">
            <?php echo esc_html($title); ?>
        </h2>

        <div class="logos-grid">
            <?php if (!empty($ids)): ?>
                <?php foreach ($ids as $id): ?>
                    <div class="logo-badge">
                        <?php echo wp_get_attachment_image($id, 'medium', false, [
                            'class'   => 'partner-logo',
                            'loading' => 'lazy',
                        ]); ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach ($fallback as $name): ?>
                    <div class="logo-badge logo-fallback">
                        <?php echo esc_html($name); ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</section>
