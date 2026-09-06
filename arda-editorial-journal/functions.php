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
