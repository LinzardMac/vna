<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package VNA_Foundation
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
?>
	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'vna' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
			echo '<p> Amount awarded: ' . get_field( 'grant_amount') . '<br>';

			$org_terms = get_the_terms( get_the_ID(), 'grant_organizations' );
			echo 'Organization: <a href="/grant_organizations/'. $org_terms[0]->slug . '">' . $org_terms[0]->name . '</a><br>';
			$terms = get_the_terms( get_the_ID(), 'grant_award_dates' );
			echo 'Award Date: <a href="/grant_award_dates/' .$terms[0]->slug . '">' . date( 'F n, Y', strtotime( $terms[0]->name ) ) . '</a></p>';

		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php  //vna_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
