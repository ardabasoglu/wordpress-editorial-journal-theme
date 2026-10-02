<?php
/**
 * Blog archive route template.
 *
 * @package ArdaEditorialJournal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$paged       = max( 1, (int) get_query_var( 'paged' ) );
$search_term = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$year_filter = isset( $_GET['year'] ) ? absint( $_GET['year'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

$query_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 12,
	'paged'               => $paged,
	'ignore_sticky_posts' => true,
	'post__not_in'        => array( 1 ),
);

if ( '' !== $search_term ) {
	$query_args['s'] = $search_term;
}

if ( $year_filter ) {
	$query_args['date_query'] = array(
		array(
			'year' => $year_filter,
		),
	);
}

$query = new WP_Query( $query_args );

global $wpdb;
$year_rows = $wpdb->get_results(
	"SELECT YEAR(post_date) AS year, COUNT(ID) AS post_count
	FROM {$wpdb->posts}
	WHERE post_type = 'post'
	AND post_status = 'publish'
	AND ID != 1
	GROUP BY YEAR(post_date)
	ORDER BY year DESC"
); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

$topic_links = array(
	'Avşa'       => 'Avşa',
	'Music'      => 'PIN music guitar',
	'Technology' => 'JavaScript WordPress DevOps Magento SSL',
	'JavaScript' => 'JavaScript',
	'WordPress'  => 'WordPress',
);

$base_blog_url = home_url( '/blog/' );

get_header();
?>

<main class="wp-block-group arda-blog-archive" id="wp--skip-link--target">
	<section class="arda-blog-intro">
		<p class="arda-kicker">All writing</p>
		<h1><?php esc_html_e( 'Blog archive', 'arda-editorial-journal' ); ?></h1>
		<p><?php esc_html_e( 'Browse the full archive of personal stories, technical notes, music memories, old photographs, and Turkish/English writing.', 'arda-editorial-journal' ); ?></p>
	</section>

	<section class="arda-blog-tools" aria-label="<?php esc_attr_e( 'Blog search and filters', 'arda-editorial-journal' ); ?>">
		<form class="arda-blog-search" action="<?php echo esc_url( $base_blog_url ); ?>" method="get">
			<label class="screen-reader-text" for="arda-blog-search-input"><?php esc_html_e( 'Search posts', 'arda-editorial-journal' ); ?></label>
			<input id="arda-blog-search-input" type="search" name="s" value="<?php echo esc_attr( $search_term ); ?>" placeholder="<?php esc_attr_e( 'Search the archive…', 'arda-editorial-journal' ); ?>">
			<?php if ( $year_filter ) : ?>
				<input type="hidden" name="year" value="<?php echo esc_attr( (string) $year_filter ); ?>">
			<?php endif; ?>
			<button type="submit"><?php esc_html_e( 'Search', 'arda-editorial-journal' ); ?></button>
		</form>

		<div class="arda-blog-filters">
			<p class="arda-filter-heading"><?php esc_html_e( 'Topics', 'arda-editorial-journal' ); ?></p>
			<?php foreach ( $topic_links as $label => $term ) : ?>
				<a class="arda-filter-chip<?php echo $search_term === $term ? ' is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 's', rawurlencode( $term ), $base_blog_url ) ); ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>

			<?php if ( $year_rows ) : ?>
				<p class="arda-filter-heading"><?php esc_html_e( 'Years', 'arda-editorial-journal' ); ?></p>
				<?php foreach ( $year_rows as $row ) : ?>
					<?php $year = (int) $row->year; ?>
					<a class="arda-filter-chip<?php echo $year_filter === $year ? ' is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'year', $year, $base_blog_url ) ); ?>"><?php echo esc_html( $year . ' (' . (int) $row->post_count . ')' ); ?></a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( $search_term || $year_filter ) : ?>
		<p class="arda-blog-active-filter">
			<?php
			printf(
				/* translators: 1: search term, 2: year */
				esc_html__( 'Showing filtered posts%1$s%2$s.', 'arda-editorial-journal' ),
				$search_term ? ' for “' . esc_html( $search_term ) . '”' : '',
				$year_filter ? ' from ' . esc_html( (string) $year_filter ) : ''
			);
			?>
			<a href="<?php echo esc_url( $base_blog_url ); ?>"><?php esc_html_e( 'Clear filters', 'arda-editorial-journal' ); ?></a>
		</p>
	<?php endif; ?>

	<?php if ( $query->have_posts() ) : ?>
		<section class="arda-blog-list" aria-label="<?php esc_attr_e( 'Blog posts', 'arda-editorial-journal' ); ?>">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				?>
				<article <?php post_class( 'arda-blog-entry' ); ?>>
					<div class="meta">
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					</div>
					<div class="content">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="excerpt"><?php the_excerpt(); ?></div>
						<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'arda-editorial-journal' ); ?></a>
					</div>
				</article>
				<?php
			endwhile;
			?>
		</section>

		<nav class="arda-blog-pagination" aria-label="<?php esc_attr_e( 'Blog pagination', 'arda-editorial-journal' ); ?>">
			<?php
			$pagination_args = array();
			if ( '' !== $search_term ) {
				$pagination_args['s'] = $search_term;
			}
			if ( $year_filter ) {
				$pagination_args['year'] = $year_filter;
			}

			echo wp_kses_post(
				paginate_links(
					array(
						'base'      => home_url( '/blog/page/%#%/' ),
						'format'    => '',
						'current'   => $paged,
						'total'     => (int) $query->max_num_pages,
						'add_args'  => $pagination_args,
						'prev_text' => __( 'Newer posts', 'arda-editorial-journal' ),
						'next_text' => __( 'Older posts', 'arda-editorial-journal' ),
					)
				)
			);
			?>
		</nav>
	<?php else : ?>
		<p><?php esc_html_e( 'No posts found. Try another search or clear the filters.', 'arda-editorial-journal' ); ?></p>
	<?php endif; ?>
</main>

<?php
wp_reset_postdata();
get_footer();
