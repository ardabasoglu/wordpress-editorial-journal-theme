<?php
/**
 * PHP template footer for theme-owned routes.
 *
 * @package ArdaEditorialJournal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	<footer class="wp-block-group arda-footer">
		<p class="has-small-font-size">© <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> · Personal journal, technology, music, and memories.</p>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
