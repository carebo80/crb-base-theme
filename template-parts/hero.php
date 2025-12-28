<?php
if (!defined('ABSPATH')) exit;

$hero_id   = (int) get_theme_mod('sa_hero_image_id', 0);
$min_vh    = (int) get_theme_mod('sa_hero_min_h', 60);
$overlay   = max(0, min(95, (int) get_theme_mod('sa_hero_overlay', 65))); // %
$text_mode = get_theme_mod('sa_hero_text', 'light'); // light|dark (optional: auto)

$hero_title    = get_theme_mod('sa_hero_title', 'Willkommen in der Stadt Apotheke Illnau-Effretikon');
$hero_subtitle = get_theme_mod('sa_hero_subtitle', 'Ihre Gesundheit liegt uns am Herzen – digital, lokal und persönlich.');

$min_h_cls = 'min-h-[' . $min_vh . 'vh]';

/**
 * WICHTIG: keine var(--c-text), sonst beeinflusst der Theme-Switcher den Hero.
 * Nimm fixe Werte:
 */
$hero_text = ($text_mode === 'light')
    ? '#ffffff'
    : 'oklch(21.6% 0.006 56.043)'; // dunkler Text, fix (wie dein light-Theme Text)

?>
<section
    class="hero relative <?php echo esc_attr($min_h_cls); ?>"
    style="--hero-a: <?php echo esc_attr($overlay / 100); ?>; --hero-text: <?php echo esc_attr($hero_text); ?>;">
    <?php if ($hero_id): ?>
        <?php
        echo wp_get_attachment_image($hero_id, 'full', false, [
            'class' => 'absolute inset-0 h-full w-full object-cover',
            'alt' => '',
            'fetchpriority' => 'high'
        ]);
        ?>
    <?php endif; ?>

    <div class="hero__overlay absolute inset-0 pointer-events-none"></div>

    <div class="relative container mx-auto px-4 text-center">
        <div class="hero-copy mx-auto max-w-4xl py-10 md:py-16 lg:py-20">
            <h1 class="text-[clamp(2.2rem,4vw+1rem,4.2rem)] md:text-[clamp(2.8rem,3.3vw+1rem,5rem)]
                 font-extrabold leading-tight tracking-tight">
                <?php echo esc_html($hero_title); ?>
            </h1>

            <p class="mt-4 text-lg md:text-2xl font-medium opacity-95">
                <?php echo esc_html($hero_subtitle); ?>
            </p>

            <a href="#features" class="icon-btn btn-outline mt-6 px-7 py-3">
                Mehr erfahren
            </a>
        </div>
    </div>
</section>
