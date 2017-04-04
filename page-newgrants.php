<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package VNA_Foundation
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();
				if ( has_post_thumbnail() ) {
					?>
					<div id="featured-image"><?php the_post_thumbnail( 'full' );?></div>
					<?php
				} else {
					// if it has a special body class assigned, use the default image for it.
					$classes = get_body_class();
					if ( in_array( 'page_about', $classes ) ) {
						$fi = get_field( 'about_featured_image', 'option' );
					}
					if ( in_array( 'page_grants', $classes ) ) {
						$fi = get_field( 'grants_featured_image', 'option' );
					}
					if ( in_array( 'page_news', $classes ) ) {
						$fi = get_field( 'news_featured_image', 'option' );
					}
					if ( isset( $fi ) ) {
						?>
						<div id="featured-image">
							<?php $src_set = ' srcset ="' . wp_get_attachment_image_srcset( $fi['id'] ) . '" '; ?>
							<img src="<?php echo $fi['url']; ?>" alt="<?php echo $fi['alt']; ?>" <?php echo $src_set; ?> />
							<?php
					}
				}
?>
						</div><!--featured-image-->
							<?php
						endwhile;

						$terms = get_terms( array(
						    'taxonomy' => 'grant_award_dates',
						    'hide_empty' => true,
								'orderby' => 'title',
								'order' => 'DESC',
								'number' => 3,
						) );

						foreach ($terms as $aterm ) {
							echo '<h2>Grant Date: ' . $aterm->name . '</h2>';

						$args = array(
							'post_type' => 'grant',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'orderby' => 'title',
							'order' => 'ASC',
							'tax_query' => array(
								array(
									'taxonomy' => 'grant_award_dates',
									'field'    => 'name',
									'terms'    => $aterm->name,
								),
							),
						);
						$grant_query = new WP_Query( $args );


						if ( $grant_query->have_posts() ) {
							while ( $grant_query->have_posts() ) : $grant_query->the_post();

								get_template_part( 'template-parts/content', 'grant' );

								// the_post_navigation();
							endwhile; // End of the loop.
						}

						wp_reset_query();
					} //foreach
?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
