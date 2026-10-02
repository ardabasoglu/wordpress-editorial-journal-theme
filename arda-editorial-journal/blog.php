<?php
/**
 * Blog archive route template.
 *
 * @package ArdaEditorialJournal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$paged = max( 1, (int) get_query_var( 'paged' ) );
$query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 12,
		'paged'               => $paged,
		'ignore_sticky_posts' => true,
		'post__not_in'        => array( 1 ),
	)
);

get_header();
?>

<main class="wp-block-group arda-blog-archive" id="wp--skip-link--target">
	<section class="arda-blog-intro">
		<p class="arda-kicker">All writing</p>
		<h1><?php esc_html_e( 'Blog archive', 'arda-editorial-journal' ); ?></h1>
		<p><?php esc_html_e( 'Browse the full archive of personal stories, technical notes, music memories, old photographs, and Turkish/English writing.', 'arda-editorial-journal' ); ?></p>
	</section>

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
			echo wp_kses_post(
				paginate_links(
					array(
						'base'      => home_url( '/blog/page/%#%/' ),
						'format'    => '',
						'current'   => $paged,
						'total'     => (int) $query->max_num_pages,
						'prev_text' => __( 'Newer posts', 'arda-editorial-journal' ),
						'next_text' => __( 'Older posts', 'arda-editorial-journal' ),
					)
				)
			);
			?>
		</nav>
	<?php else : ?>
		<p><?php esc_html_e( 'No posts found.', 'arda-editorial-journal' ); ?></p>
	<?php endif; ?>
</main>

<?php
wp_reset_postdata();
get_footer();
