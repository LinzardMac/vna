<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package VNA_Foundation
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'vna' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">

			<div id="header-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php the_header_image_tag(); ?></a></div>
			<?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;
			?>

		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
<?php
if ( function_exists( 'ubermenu' ) ) {
	ubermenu( 'main' , array( 'menu' => 4 ) );
} else {
	wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) );
}?>
		</nav><!-- #site-navigation -->
		<div id="header-additional">
		<?php
		the_field( 'wagw_header', 'option' );
	 	?>
	</div>
		<?php
					$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php
					endif; ?>


	</header><!-- #masthead -->

	<div id="content" class="site-content">
