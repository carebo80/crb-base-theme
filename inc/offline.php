<?php
if (!defined('ABSPATH')) exit;

add_action('template_redirect', function () {
  $enabled = (bool) get_theme_mod('crb_site_offline', false);
  if (!$enabled) return;

  // Admins dürfen rein
  if (is_user_logged_in() && current_user_can('manage_options')) return;

  // WP-Backend / Login / AJAX / REST nicht blocken
  if (is_admin() || wp_doing_ajax() || (defined('REST_REQUEST') && REST_REQUEST)) return;
  $pagenow = $GLOBALS['pagenow'] ?? '';
  if (in_array($pagenow, ['wp-login.php', 'wp-register.php'], true)) return;

  // 503 + Retry-After (SEO/Clients korrekt)
  status_header(503);
  header('Retry-After: 3600');
  nocache_headers();

  $msg = get_theme_mod('crb_offline_message', 'Wir sind in Kürze wieder online.');
  $brand = trim((string) get_theme_mod('crb_brand_text', ''));
  if ($brand === '') $brand = get_bloginfo('name');

  // Mini-HTML (ohne Theme-Abhängigkeit)
  $logo_html = '';
  if (function_exists('has_custom_logo') && has_custom_logo()) {
    $logo_html = get_custom_logo();
  }

  echo '<!doctype html><html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">';
  echo '<title>' . esc_html($brand) . ' – Wartung</title>';
  echo '<style>
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu; background:#f6f7f6; color:#111;}
    .wrap{min-height:100vh;display:grid;place-items:center;padding:24px;}
    .card{max-width:720px;width:100%;background:#fff;border:1px solid rgba(0,0,0,.08);border-radius:20px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,.06);}
    .top{
  padding:22px 24px;
  background:rgba(0,102,0,.05);
  border-bottom:1px solid rgba(0,102,0,.15);
}
.top h1{color:#064;}
    .top h1{
  margin:0;
  color:#111; /* oder #064 wenn du grün willst */
  font-size:28px;
  line-height:1.2;
}
    .body{padding:22px 24px}
    .body p{margin:0 0 12px;opacity:.9;font-size:16px;line-height:1.6}
    .brand{display:flex;gap:12px;align-items:center}
    .brand .custom-logo{max-height:42px;width:auto}
  </style></head><body><div class="wrap"><div class="card">';
  echo '<div class="top"><div class="brand">' . $logo_html . '<h1>' . esc_html($brand) . '</h1></div></div>';
  echo '<div class="body"><p><strong>Wartungsarbeiten</strong></p><p>' . esc_html($msg) . '</p></div>';
  echo '</div></div></body></html>';
  exit;
}, 0);
