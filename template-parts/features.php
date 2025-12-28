<?php

/**
 * Features / Dienstleistungen Section
 *
 * @package crb-base-theme
 */

$features_title = get_theme_mod('crb_features_title', 'Unsere Dienstleistungen');
$text_mode      = get_theme_mod('crb_features_text_mode', 'dark');
$features_bg = ($text_mode === 'light')
    ? 'transparent'          // oder 'var(--c-primary)' wenn du willst
    : 'transparent';
$features_text = ($text_mode === 'light')
    ? '#ffffff'
    : 'var(--c-text)';
?>
<section id="features" class="py-10 md:py-16"
    style="--features-text: <?php echo esc_attr($features_text); ?>;
         --features-bg: <?php echo esc_attr($features_bg); ?>;">
    <div class="container px-4">

        <header class="mb-8 md:mb-10">
            <h2 class="section-title" style="color: var(--features-text);">
                <?php echo esc_html($features_title); ?>
            </h2>
        </header>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

            <!-- Karte 1 -->
            <article class="group h-full rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow"
                style="background-color: var(--c-surface); border: 1px solid var(--c-border);">
                <a href="#" class="block overflow-hidden">
                    <img
                        class="w-full aspect-[4/3] object-cover transform transition-transform duration-500 group-hover:scale-105"
                        src="/wp-content/uploads/2025/12/beratung.png"
                        alt="Beratung &amp; Service">
                </a>

                <div class="p-5" style="color: var(--c-text);">
                    <h3 class="text-xl font-semibold mb-1">
                        <a href="#" class="no-underline transition-colors group-hover:text-[var(--c-primary)]">
                            Beratung &amp; Service
                        </a>
                    </h3>
                    <p class="text-sm leading-relaxed" style="color: var(--c-muted);">
                        Bestellen Sie pharmazeutische und Schönheitsprodukte bequem online.
                    </p>
                </div>
            </article>

            <!-- Karte 2 -->
            <article class="group h-full rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow"
                style="background-color: var(--c-surface); border: 1px solid var(--c-border);">

                <a href="#" class="block overflow-hidden">
                    <img
                        class="w-full aspect-[4/3] object-cover transform transition-transform duration-500 group-hover:scale-105"
                        src="/wp-content/uploads/2025/12/online_shop.png"
                        alt="Online Shop">
                </a>

                <div class="p-5" style="color: var(--c-text);">
                    <h3 class="text-xl font-semibold mb-1">
                        <a href="#" class="no-underline transition-colors group-hover:text-[var(--c-primary)]">
                            Online Shop
                        </a>
                    </h3>
                    <p class="text-sm leading-relaxed" style="color: var(--c-muted);">
                        Bestellen Sie pharmazeutische und Schönheitsprodukte bequem online.
                    </p>
                </div>
            </article>

            <!-- Karte 3 -->
            <article class="group h-full rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow"
                style="background-color: var(--c-surface); border: 1px solid var(--c-border);">

                <a href="#" class="block overflow-hidden">
                    <img
                        class="w-full aspect-[4/3] object-cover transform transition-transform duration-500 group-hover:scale-105"
                        src="/wp-content/uploads/2025/12/termin.png"
                        alt="Termin online buchen">
                </a>

                <div class="p-5" style="color: var(--c-text);">
                    <h3 class="text-xl font-semibold mb-1">
                        <a href="#" class="no-underline transition-colors group-hover:text-[var(--c-primary)]">
                            Termin online buchen
                        </a>
                    </h3>
                    <p class="text-sm leading-relaxed" style="color: var(--c-muted);">
                        Buchen Sie eine persönliche Beratung online.
                    </p>
                </div>
            </article>

            <!-- Karte 4 -->
            <article class="group h-full rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow"
                style="background-color: var(--c-surface); border: 1px solid var(--c-border);">

                <a href="#" class="block overflow-hidden">
                    <img
                        class="w-full aspect-[4/3] object-cover transform transition-transform duration-500 group-hover:scale-105"
                        src="/wp-content/uploads/2025/12/rezepte_upload.png"
                        alt="Rezepte Upload">
                </a>

                <div class="p-5" style="color: var(--c-text);">
                    <h3 class="text-xl font-semibold mb-1">
                        <a href="#" class="no-underline transition-colors group-hover:text-[var(--c-primary)]">
                            Rezepte Upload
                        </a>
                    </h3>
                    <p class="text-sm leading-relaxed" style="color: var(--c-muted);">
                        Laden Sie Ihr Medikamentenrezept bequem digital hoch.
                    </p>
                </div>
            </article>

        </div>
    </div>
</section>
