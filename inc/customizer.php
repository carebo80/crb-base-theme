<?php
if (!defined('ABSPATH')) exit;

add_action('customize_register', function (WP_Customize_Manager $wp_customize) {

	$wp_customize->add_setting('crb_site_offline', [
		'default' => false,
		'sanitize_callback' => fn($v) => (bool)$v,
	]);

	$wp_customize->add_control('crb_site_offline', [
		'label'       => __('Seite offline (Wartungsmodus)', 'crb-base-theme'),
		'description' => __('Nur Admins sehen die Seite normal.', 'crb-base-theme'),
		'section'     => 'title_tagline',
		'type'        => 'checkbox',
	]);

	$wp_customize->add_setting('crb_offline_message', [
		'default' => 'Wir sind in Kürze wieder online.',
		'sanitize_callback' => 'sanitize_textarea_field',
	]);

	$wp_customize->add_control('crb_offline_message', [
		'label'   => __('Offline-Text', 'crb-base-theme'),
		'section' => 'title_tagline',
		'type'    => 'textarea',
	]);

	// Hero
	$wp_customize->add_section('crb_hero_section', [
		'title'    => __('Hero', 'crb-base-theme'),
		'priority' => 30,
	]);

	$wp_customize->add_setting('sa_hero_image_id', [
		'default'           => 0,
		'sanitize_callback' => 'absint',
	]);

	$wp_customize->add_control(new WP_Customize_Media_Control(
		$wp_customize,
		'sa_hero_image_id',
		[
			'label'     => __('Hero Hintergrundbild', 'crb-base-theme'),
			'section'   => 'crb_hero_section',
			'mime_type' => 'image',
		]
	));

	$wp_customize->add_setting('sa_hero_min_h', [
		'default'           => 60,
		'sanitize_callback' => 'absint',
	]);

	$wp_customize->add_control('sa_hero_min_h', [
		'label'       => __('Hero Mindesthöhe (vh)', 'crb-base-theme'),
		'type'        => 'number',
		'section'     => 'crb_hero_section',
		'input_attrs' => ['min' => 30, 'max' => 100, 'step' => 5],
	]);

	$wp_customize->add_setting('sa_hero_overlay', [
		'default'           => 65,
		'sanitize_callback' => 'absint',
	]);

	$wp_customize->add_control('sa_hero_overlay', [
		'label'       => __('Overlay Deckkraft (%)', 'crb-base-theme'),
		'type'        => 'number',
		'section'     => 'crb_hero_section',
		'input_attrs' => ['min' => 0, 'max' => 95, 'step' => 5],
	]);

	$wp_customize->add_setting('sa_hero_title', [
		'default'           => 'Willkommen in der Stadt Apotheke Illnau-Effretikon',
		'sanitize_callback' => 'sanitize_text_field',
	]);

	$wp_customize->add_control('sa_hero_title', [
		'label'   => __('Hero-Titel', 'crb-base-theme'),
		'section' => 'crb_hero_section',
		'type'    => 'text',
	]);

	$wp_customize->add_setting('sa_hero_subtitle', [
		'default'           => 'Ihre Gesundheit liegt uns am Herzen – digital, lokal und persönlich.',
		'sanitize_callback' => 'sanitize_textarea_field',
	]);

	$wp_customize->add_control('sa_hero_subtitle', [
		'label'   => __('Hero-Untertitel', 'crb-base-theme'),
		'section' => 'crb_hero_section',
		'type'    => 'textarea',
	]);
	// Hero Textmodus (hell/dunkel)
	$wp_customize->add_setting('sa_hero_text', [
		'default' => 'light',
		'sanitize_callback' => function ($v) {
			return in_array($v, ['light', 'dark'], true) ? $v : 'light';
		},
	]);

	$wp_customize->add_control('sa_hero_text', [
		'label'   => __('Textfarbe im Hero', 'crb-base-theme'),
		'section' => 'crb_hero_section',
		'type'    => 'radio',
		'choices' => [
			'light' => __('Hell (weiß)', 'crb-base-theme'),
			'dark'  => __('Dunkel', 'crb-base-theme'),
		],
	]);

	// Farben
	$wp_customize->add_section('crb_primary_colors', [
		'title'    => __('Farben', 'crb-base-theme'),
		'priority' => 31,
	]);

	$wp_customize->add_setting('crb_primary_color', [
		'default'           => '#006600',
		'sanitize_callback' => 'sanitize_hex_color',
	]);

	$wp_customize->add_control(new WP_Customize_Color_Control(
		$wp_customize,
		'crb_primary_color',
		[
			'label'   => __('Primary Color', 'crb-base-theme'),
			'section' => 'crb_primary_colors',
		]
	));

	$wp_customize->add_setting('crb_secondary_color', [
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	]);

	$wp_customize->add_control(new WP_Customize_Color_Control(
		$wp_customize,
		'crb_secondary_color',
		[
			'label'   => __('Secondary Color', 'crb-base-theme'),
			'section' => 'crb_primary_colors',
		]
	));

	// Header / Navigation
	$wp_customize->add_section('crb_header_section', [
		'title'    => __('Header / Navigation', 'crb-base-theme'),
		'priority' => 32,
	]);

	$wp_customize->add_setting('crb_nav_style', [
		'default' => 'pills',
		'sanitize_callback' => fn($v) => in_array($v, ['pills', 'underline'], true) ? $v : 'pills',
	]);

	$wp_customize->add_control('crb_nav_style', [
		'label'   => __('Nav Style', 'crb-base-theme'),
		'section' => 'crb_header_section',
		'type'    => 'radio',
		'choices' => [
			'pills'     => __('Pills', 'crb-base-theme'),
			'underline' => __('Underline', 'crb-base-theme'),
		],
	]);

	$wp_customize->add_setting('crb_icon_button_outline', [
		'default' => true,
		'sanitize_callback' => fn($v) => (bool)$v,
	]);

	$wp_customize->add_control('crb_icon_button_outline', [
		'label'   => __('Icon-Buttons mit Rahmen', 'crb-base-theme'),
		'section' => 'crb_header_section',
		'type'    => 'checkbox',
	]);

	$wp_customize->add_setting('crb_icon_button_size', [
		'default' => 'md',
		'sanitize_callback' => function ($v) {
			return in_array($v, ['sm', 'md', 'lg'], true) ? $v : 'md';
		},
	]);

	$wp_customize->add_control('crb_icon_button_size', [
		'label'   => __('Icon-Button Größe', 'crb-base-theme'),
		'section' => 'crb_header_section',
		'type'    => 'radio',
		'choices' => [
			'sm' => __('Klein', 'crb-base-theme'),
			'md' => __('Mittel', 'crb-base-theme'),
			'lg' => __('Gross', 'crb-base-theme'),
		],
	]);
});
add_action('wp_head', function () {
	$primary   = get_theme_mod('crb_primary_color', '#006600') ?: '#006600';
	$secondary = get_theme_mod('crb_secondary_color', '#ffffff') ?: '#ffffff';

	echo '<style id="crb-colors">:root{'
		. '--c-primary:'   . esc_attr($primary)   . ';'
		. '--c-secondary:' . esc_attr($secondary) . ';'
		. '}</style>';
}, 20);
