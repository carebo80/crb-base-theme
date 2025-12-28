<?php
if (!defined('ABSPATH')) exit;

$show_switcher = (bool) get_theme_mod('crb_show_theme_switcher', true);
$show_search   = (bool) get_theme_mod('crb_show_search', true);
$show_mail     = (bool) get_theme_mod('crb_show_mail_button', true);
$nav_style     = get_theme_mod('crb_nav_style', 'pills'); // pills|underline
$fullwidth     = (bool) get_theme_mod('crb_header_fullwidth', true);

$container_cls = $fullwidth ? 'w-full px-3 sm:px-4 md:px-6 lg:px-8' : 'container mx-auto px-4';

$myacc_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
$cart_url  = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/warenkorb/');
$cart_count = (class_exists('WooCommerce') && WC()->cart)
	? (int) WC()->cart->get_cart_contents_count()
	: 0;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Pre-paint Dark Mode (no FOUC) -->
	<script>
		(function() {
			try {
				var DEF = <?php echo json_encode(get_theme_mod('crb_theme_default', 'system')); ?>;
				var saved = localStorage.getItem('theme') || DEF;
				var dark = (saved === 'dark') || (saved === 'system' && matchMedia('(prefers-color-scheme: dark)').matches);
				document.documentElement.classList.toggle('dark', dark);
				document.documentElement.dataset.theme = saved;
			} catch (e) {}
		})();
	</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class('antialiased'); ?>>
	<?php wp_body_open(); ?>
	<header
		x-data="crbHeader()"
		x-init="init()"
		class="crb-site-header sticky z-50 backdrop-blur relative"
		style="top: var(--wp-admin--admin-bar--height, 0px);"
		:class="{'shadow-md': scrolled}">

		<div class="<?php echo esc_attr($container_cls); ?>">
			<div class="flex h-16 items-center gap-3">

				<!-- LEFT: Burger (mobile) + Logo + Desktop Nav -->
				<div class="flex items-center gap-3 min-w-0">
					<!-- Hamburger: mobile only -->
					<button class="icon-btn lg:hidden"
						@click="navOpen = !navOpen"
						:aria-expanded="navOpen ? 'true' : 'false'"
						aria-controls="primary-navigation-mobile"
						aria-label="Navigation öffnen">
						<svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M3.75 6.75H20.25M3.75 12H20.25M3.75 17.25H20.25"
								stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
						</svg>
					</button>

					<a href="<?php echo esc_url(home_url('/')); ?>" class="shrink-0 block" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
						<?php
						if (has_custom_logo()) {
							the_custom_logo();
						} else {
							echo '<span class="font-bold text-lg">' . esc_html(get_bloginfo('name')) . '</span>';
						}
						?>
					</a>

					<!-- Desktop Primary Nav (left-aligned next to logo) -->
					<nav id="primary-navigation"
						class="hidden lg:block crb-primary-nav"
						:class="{'crb-nav-hidden': scrolled}">
						<?php
						wp_nav_menu([
							'theme_location' => 'primary',
							'container'      => false,
							'fallback_cb'    => false,
							'menu_class'     => 'crb-menu crb-menu--' . esc_attr($nav_style),
							'walker'         => new CRB_Nav_Walker(),
						]);
						?>
					</nav>
				</div>

				<div class="flex-1"></div>

				<!-- RIGHT: System links -->
				<div class="flex items-center gap-1 sm:gap-2">

					<?php if ($show_search): ?>
						<button class="icon-btn"
							@click="openSearch()"
							aria-label="<?php esc_attr_e('Suche öffnen', 'crb-base-theme'); ?>">
							<?php echo crb_heroicon('magnifying-glass', 'outline', 'h-5 w-5'); ?>
						</button>
					<?php endif; ?>

					<?php if ($show_switcher): ?>
						<?php get_template_part('template-parts/ui/theme-switcher'); ?>
					<?php endif; ?>

					<?php if ($show_mail): ?>
						<a class="icon-btn" href="mailto:info@example.com" aria-label="<?php esc_attr_e('E-Mail', 'crb-base-theme'); ?>">
							<?php echo crb_heroicon('envelope', 'outline', 'h-5 w-5'); ?>
						</a>
					<?php endif; ?>

					<!-- Account -->
					<a class="icon-btn" href="<?php echo esc_url($myacc_url); ?>" aria-label="<?php esc_attr_e('Mein Konto', 'crb-base-theme'); ?>">
						<?php echo crb_heroicon('user', 'outline', 'h-5 w-5'); ?>
					</a>

					<!-- Cart (WooCommerce optional) -->
					<?php if (function_exists('WC')): ?>
						<a class="icon-btn relative" href="<?php echo esc_url($cart_url); ?>" aria-label="<?php esc_attr_e('Warenkorb', 'crb-base-theme'); ?>">
							<?php echo crb_heroicon('shopping-bag', 'outline', 'h-5 w-5'); ?>
							<?php if ($cart_count > 0): ?>
								<span class="cart-badge"><?php echo (int) $cart_count; ?></span>
							<?php endif; ?>
						</a>
					<?php endif; ?>

					<!-- Hamburger duplicate on very small? not needed -->
				</div>
			</div>
		</div>

		<!-- Mobile Nav Panel -->
		<nav id="primary-navigation-mobile"
			class="lg:hidden border-t"
			x-show="navOpen"
			x-transition
			@click.outside="navOpen=false"
			@keydown.escape.window="navOpen=false"
			style="display:none">
			<div class="<?php echo esc_attr($container_cls); ?> py-3">
				<?php
				wp_nav_menu([
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => false,
					'menu_class'     => 'crb-menu-mobile',
					'walker'         => new CRB_Nav_Walker(),
				]);
				?>
			</div>
		</nav>

		<!-- Search Overlay -->
		<?php if ($show_search): ?>
			<div
				class="fixed inset-0 z-40 backdrop-blur-sm"
				x-show="searchOpen"
				x-transition.opacity
				@click="closeSearch()"
				@keydown.escape.window="closeSearch()"
				style="display:none">
			</div>
			<?php endif; ?><?php if ($show_search): ?>
			<div
				class="crb-search-overlay absolute inset-x-0 top-full z-50"
				x-show="searchOpen"
				x-transition
				@keydown.escape.window="closeSearch()"
				style="display:none">
				<div class="<?php echo esc_attr($container_cls); ?> pt-3 sm:pt-4">
					<div class="crb-search-panel p-3 sm:p-4"
						@click.stop>
						<div class="flex items-center gap-2">
							<div class="flex-1">
								<?php get_search_form(); ?>
							</div>
							<button class="icon-btn" @click="closeSearch()" aria-label="<?php esc_attr_e('Suche schließen', 'crb-base-theme'); ?>">
								<?php echo crb_heroicon('x-mark', 'outline', 'h-5 w-5'); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		</div>
	</header>
