<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package VNA_Foundation
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		$classes = get_body_class();
		$fi='';
		if ( in_array( 'page_about', $classes ) ) {
			$fi = 'About: ';
		}
		if ( in_array( 'page_grants', $classes ) ) {
			$fi = 'Grants: ';
		}
		if ( in_array( 'page_news', $classes ) ) {
			$fi = 'News: ';
		}
		?>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title"><span style="font-weight:normal;">' . $fi . '</span>', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'vna' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'vna' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->
