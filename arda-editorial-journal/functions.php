<?php
/**
 * Arda Editorial Journal theme functions.
 *
 * @package ArdaEditorialJournal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue child theme stylesheet and editorial fonts.
 */
function arda_editorial_journal_enqueue_styles() {
	wp_enqueue_style(
		'arda-editorial-journal-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Inter:wght@400;500;600;700;800;900&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'arda-editorial-journal-style',
		get_stylesheet_uri(),
		array( 'arda-editorial-journal-fonts' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'arda_editorial_journal_enqueue_styles' );

/**
 * Add a theme-owned /blog/ archive route so all posts are reachable
 * without requiring a WordPress page to exist in the database.
 */
function arda_editorial_journal_add_blog_route() {
	add_rewrite_rule( '^blog/page/([0-9]+)/?$', 'index.php?arda_blog_archive=1&paged=$matches[1]', 'top' );
	add_rewrite_rule( '^blog/?$', 'index.php?arda_blog_archive=1', 'top' );
}
add_action( 'init', 'arda_editorial_journal_add_blog_route' );

/**
 * Register the custom query variable used by the /blog/ route.
 *
 * @param array $vars Public query variables.
 * @return array
 */
function arda_editorial_journal_query_vars( $vars ) {
	$vars[] = 'arda_blog_archive';
	return $vars;
}
add_filter( 'query_vars', 'arda_editorial_journal_query_vars' );

/**
 * Use the custom blog archive template for /blog/.
 *
 * @param string $template Current template path.
 * @return string
 */
function arda_editorial_journal_blog_template( $template ) {
	if ( get_query_var( 'arda_blog_archive' ) ) {
		$blog_template = get_stylesheet_directory() . '/blog.php';
		if ( file_exists( $blog_template ) ) {
			return $blog_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'arda_editorial_journal_blog_template' );

/**
 * Flush rewrite rules when the theme is activated so /blog/ works immediately.
 */
function arda_editorial_journal_after_switch_theme() {
	arda_editorial_journal_add_blog_route();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'arda_editorial_journal_after_switch_theme' );
