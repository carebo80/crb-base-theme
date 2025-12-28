<?php
if (!defined('ABSPATH')) exit;

if (!function_exists('crb_heroicon')) {
    function crb_heroicon(string $name, string $style = 'outline', string $class = ''): string
    {
        // outline|solid|mini|micro
        $style = in_array($style, ['outline', 'solid', 'mini', 'micro'], true) ? $style : 'outline';

        // Pfade passend zu heroicons-master/src
        $map = [
            'outline' => 'src/24/outline',
            'solid'   => 'src/24/solid',
            'mini'    => 'src/20/solid',
            'micro'   => 'src/16/solid',
        ];

        $file = CRB_BASE_THEME_DIR . '/assets/icons/heroicons/heroicons-master/' . $map[$style] . '/' . $name . '.svg';
        if (!file_exists($file)) return '';
        $svg = file_get_contents($file);
        if (!$svg) return '';

        // 1) width/height entfernen -> CSS steuert Größe
        $svg = preg_replace('/\s(width|height)="[^"]*"/i', '', $svg);

        // 2) (Optional aber empfehlenswert) keine Farbrewrites bei Heroicons
        //    => Heroicons sind i.d.R. bereits currentColor/fill=none korrekt.
        //    Wenn du unbedingt willst: lass es weg, sonst riskierst du Outline-Icons zu “füllen”.

        // 3) class ins <svg> (sicher escapen)
        if ($class) {
            $class = esc_attr($class);
            if (preg_match('/<svg[^>]*\sclass="/i', $svg)) {
                $svg = preg_replace('/(<svg[^>]*\sclass=")([^"]*)"/i', '$1$2 ' . $class . '"', $svg, 1);
            } else {
                $svg = preg_replace('/<svg\b/i', '<svg class="' . $class . '"', $svg, 1);
            }
        }

        // 4) a11y default: dekorativ
        if (!preg_match('/\saria-hidden="/i', $svg)) {
            $svg = preg_replace('/<svg\b/i', '<svg aria-hidden="true" focusable="false"', $svg, 1);
        }

        return $svg;
    }
}

if (!function_exists('crb_heroicon_list')) {
    function crb_heroicon_list(): array
    {
        $base = CRB_BASE_THEME_DIR . '/assets/icons/heroicons/heroicons-master/src';
        $map = [
            'outline' => '24/outline',
            'solid'   => '24/solid',
            'mini'    => '20/solid',
            'micro'   => '16/solid',
        ];

        $out = ['outline' => [], 'solid' => [], 'mini' => [], 'micro' => []];

        foreach ($map as $key => $rel) {
            $dir = $base . '/' . $rel;
            if (!is_dir($dir)) continue;
            foreach (glob($dir . '/*.svg') ?: [] as $file) {
                $out[$key][] = basename($file, '.svg');
            }
            sort($out[$key]);
        }
        return $out;
    }
}
