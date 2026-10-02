<?php
/**
 * PHP template header for theme-owned routes.
 *
 * @package ArdaEditorialJournal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="wp-site-blocks">
	<header class="wp-block-group arda-topbar">
		<p class="wp-block-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<nav class="wp-block-group arda-nav" aria-label="<?php esc_attr_e( 'Main navigation', 'arda-editorial-journal' ); ?>">
			<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'arda-editorial-journal' ); ?></a></p>
			<p><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'arda-editorial-journal' ); ?></a></p>
			<p><a href="<?php echo esc_url( home_url( '/#elsewhere' ) ); ?>"><?php esc_html_e( 'Links', 'arda-editorial-journal' ); ?></a></p>
			<p><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Contact', 'arda-editorial-journal' ); ?></a></p>
		</nav>
	</header>
