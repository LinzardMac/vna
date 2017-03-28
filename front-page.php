<?php
/**
 * The template for the front page
 *
 * This makes extensive use of content from Advanced Custom Fields
 *
 * Page order is
 *   slider
 *   content
 *   boxes
 *   news area title
 *   3 recent posts
 *   general stuff area
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

				if ( have_rows( 'slides' ) ) {
					$use_srcset = false;
					if ( function_exists( 'wp_get_attachment_image_srcset' ) ) { $use_srcset = true; }

					/// ?>

			<div id="slider" class="flexslider slider-save-space">
			<ul class="slides">
			<?php
			$carousel = ''; // in case there's a carousel
			while ( have_rows( 'slides' ) ) { the_row();
				$image = get_sub_field( 'slide_image' );
				$slide_title = get_sub_field( 'slide_title' );
				$slide_caption = get_sub_field( 'slide_caption' );
				$slide_target = get_sub_field( 'slide_target' );
				if ( $slide_target ) {
					$href = '<a href="' . $slide_target . '">';
				}
				if ( $use_srcset ) {
					$src_set = ' srcset ="' . wp_get_attachment_image_srcset( $image['id'] ) . '" ';
				} else {
					$src_set = '';
				}
?>
		 <li><?php if ( $slide_target ) { echo $href; } ?><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" <?php echo $src_set; ?> /><?php if ( $slide_target ) { echo '</a>'; } ?>
				<?php if ( get_field( 'show_image_captions' ) ) { ?>
					<div class="flex-caption">
				<?php if ( $slide_title ) { ?> <span class="caption_title"><?php echo $slide_title; }?>
				<?php if ( $slide_caption ) { ?></span><?php echo $slide_caption; } ?></div>
				<?php } // captions ?>
					</li>
				<?php
				/* if a carousel is set, build  the carousel here and display later */
				if ( get_field( 'slider_carousel' ) ) {
					$carousel .= '<li><img src="' . $image['url'] . '" ' . $src_set . "/></li>\n";
				}
				?>
				<?php } // while have rows ?>
				</ul>
				</div>
				<?php if ( get_field( 'slider_carousel' ) ) { ?>
			<div id="carousel" class="flexslider">
				<ul class="slides">
					<?php echo $carousel; ?>
	      </ul>
			</div>

		<?php	} // carousel
				} // images ?>

<div id="content_area"> <?php the_content(); ?> </div>

<div id="feature_boxes_area">

	<a href="<?php the_field( 'box_1_link' );?>">
	<div id="feature_1_box" class="feature_box">
		<div class="feature_box_title"><?php the_field( 'box_1_title' ); ?></div>
		<div class="feature_box_image">
			<?php
			$image = get_field( 'box_1_image' );
			$src_set = ' srcset ="' . wp_get_attachment_image_srcset( $image['id'] ) . '" ';
			echo '<img src="' . $image['url'] . '" ' . $src_set . '/>';
			?>
		</div>
		<div class=feature_box_caption><?php the_field( 'feature_1_box_caption' ); ?></div>
	</div>
</a>


<a href="<?php the_field( 'box_2_link' );?>">
<div id="feature_2_box" class="feature_box">
	<div class="feature_box_title"><?php the_field( 'box_2_title' ); ?></div>
	<div class="feature_box_image">
		<?php
		$image = get_field( 'box_2_image' );
		$src_set = ' srcset ="' . wp_get_attachment_image_srcset( $image['id'] ) . '" ';
		echo '<img src="' . $image['url'] . '" ' . $src_set . '/>';
		?>
	</div>
	<div class=feature_box_caption><?php the_field( 'feature_2_box_caption' ); ?></div>
</div>
</a>

</div>

<h2 class="post_boxes_title"><?php the_field( 'post_boxes_title' ); ?></h2>

<?php $recent_posts = vna_get_recent_posts( 3 ); ?>



<?php
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
