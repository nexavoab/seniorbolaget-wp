<?php
/**
 * Seniorbolaget theme functions
 *
 * @package Seniorbolaget
 * @version 1.0.0
 */

define( 'SENIORBOLAGET_VERSION', '1.0.0' );

/**
 * Theme setup.
 */
function seniorbolaget_setup() {
	load_theme_textdomain( 'seniorbolaget', get_template_directory() . '/languages' );

	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primär meny', 'seniorbolaget' ),
			'footer'  => __( 'Sidfots-meny', 'seniorbolaget' ),
		)
	);
}
add_action( 'after_setup_theme', 'seniorbolaget_setup' );

/**
 * Enqueue scripts and styles.
 */
function seniorbolaget_scripts() {
	// Inter från Google Fonts
	wp_enqueue_style(
		'seniorbolaget-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// Tema-stilar
	wp_enqueue_style(
		'seniorbolaget-style',
		get_stylesheet_uri(),
		array( 'seniorbolaget-fonts' ),
		SENIORBOLAGET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'seniorbolaget_scripts' );

/**
 * Enqueue editor styles.
 */
function seniorbolaget_editor_styles() {
	add_editor_style( 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap' );
}
add_action( 'after_setup_theme', 'seniorbolaget_editor_styles' );

/**
 * Block patterns kategori.
 */
function seniorbolaget_register_pattern_categories() {
	register_block_pattern_category(
		'seniorbolaget',
		array( 'label' => __( 'Seniorbolaget', 'seniorbolaget' ) )
	);
}
add_action( 'init', 'seniorbolaget_register_pattern_categories' );

// Feature flags
require_once get_template_directory() . '/inc/feature-flags.php';

// Manuell registrering av stadssida-mönster (bypass auto-scan)
function seniorbolaget_register_stad_patterns() {
    $pattern_dir = get_template_directory() . '/patterns/';
    $stad_patterns = glob($pattern_dir . 'stad-*.php');
    foreach ($stad_patterns as $file) {
        $headers = get_file_data($file, array(
            'title'       => 'Title',
            'slug'        => 'Slug',
            'description' => 'Description',
            'categories'  => 'Categories',
        ));
        if (empty($headers['slug'])) continue;
        ob_start();
        include $file;
        $content = ob_get_clean();
        register_block_pattern($headers['slug'], array(
            'title'       => $headers['title'],
            'description' => $headers['description'],
            'categories'  => array_map('trim', explode(',', $headers['categories'])),
            'content'     => $content,
        ));
    }
}
add_action('init', 'seniorbolaget_register_stad_patterns', 20);
