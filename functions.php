<?php
/**
 * VNA Foundation functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions
 *
 * @package VNA_Foundation
 */

if ( ! function_exists( 'vna_setup' ) ) :
	/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
	function vna_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on VNA Foundation, use a find and replace
		 * to change 'vna' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'vna', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'vna' ),
		) );

			/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			) );

			// Set up the WordPress core custom background feature.
			add_theme_support( 'custom-background', apply_filters( 'vna_custom_background_args', array(
				'default-color' => 'ffffff',
				'default-image' => '',
			) ) );

			// Add theme support for selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'vna_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vna_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'vna_content_width', 640 );
}
add_action( 'after_setup_theme', 'vna_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vna_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'vna' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'vna' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'vna_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function vna_scripts() {
	wp_enqueue_style( 'vna-style', get_stylesheet_uri() );

	wp_enqueue_script( 'vna-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'vna-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Oswald:300,400,600,700' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_front_page() || is_page_template( 'slideshow-page.php' ) ) {
		wp_enqueue_style( 'flexslider-css', get_stylesheet_directory_uri() . '/flexslider/flexslider.css' );
	}

}
add_action( 'wp_enqueue_scripts', 'vna_scripts' );

function theme_typekit() {
    wp_enqueue_script( 'theme_typekit', '//use.typekit.net/fot7alu.js');
}
add_action( 'wp_enqueue_scripts', 'theme_typekit' );
function theme_typekit_inline() {
  if ( wp_script_is( 'theme_typekit', 'done' ) ) { ?>
        <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<?php }
}
add_action( 'wp_head', 'theme_typekit_inline' );


function wagw_flexslider_gallery_scripts() {
	if ( is_front_page() || is_page_template( 'slideshow-page.php' ) ) {
			wp_enqueue_script( 'jquery' );
	        wp_enqueue_script( 'jquery-easing', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js',array( 'jquery' ), false, false );
			wp_register_script( 'flexslider', get_stylesheet_directory_uri() . '/flexslider/jquery.flexslider-min.js', array( 'jquery', 'jquery-easing' ), false, false );
			wp_register_script( 'load_flex', get_stylesheet_directory_uri() . '/js/load-flex.js', array( 'jquery', 'flexslider' ), false, false );

			$speed = get_field( 'slideshow_speed' );
			$animation = get_field( 'animation_speed' );
			$animation_type = get_field( 'animation_type' );
			$easing = get_field( 'easing_method' );
			$controlNav = $directionNav = false;
		if ( get_field( 'nextprev_arrows' ) ) { $directionNav = true; }
		if ( get_field( 'navigation_dots' ) ) { $controlNav = true; }
		if ( get_field( 'slider_carousel' ) ) { $controlNav = 'thumbnails'; }

			// get the settings for this post

			$args = array(
			'animation'       => $animation_type,
			'animationSpeed'  => $animation,
			'slideshowSpeed'  => $speed,
			'controlNav'      => $controlNav,
			'directionNav'    => $directionNav,
			'easing'          => $easing,

			 );
			wp_enqueue_script( 'flexslider' );
			wp_localize_script( 'load_flex', 'wagw', $args );
			wp_enqueue_script( 'load_flex' );
	}
}
	add_action( 'wp_enqueue_scripts', 'wagw_flexslider_gallery_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

function vna_get_recent_posts( $count ) {
	$args = array(
		'posts_per_page' => $count,
		'post_type' => 'post',
		'orderby' => 'date',
		'order' => 'DESC',
		'post_status' => array( 'publish' ),
	);
		$q = new WP_QUERY( $args );
		$count = 0;
	if (	$q->have_posts() ) {

		while ( $q->have_posts() ) {
			if ( ($count % 3 ) == 0 ) {
				echo '<div class="fp-post-row">';
			}
			echo '<div class="fp-post">';
			$q->the_post();
			if ( has_post_thumbnail() ) {
				echo '<div class="fp-thumbnail">';
				echo '<a href="' . get_the_permalink() . '">';
				the_post_thumbnail( 'full' );
				echo '</a>';
				echo '</div>';
			}
			echo '<div class="fp-post-content">';
			echo '<h3 class="fp_post_title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
			echo '</div>';

			echo '</div>';
			if ( ($count % 3 ) == 2 ) {
				echo '</div> <!--class="fp-post-row"-->';
			}
						$count++;
		}
		wp_reset_postdata();
	}
}

/*
 * Add ACF Options page
 */
acf_add_options_page(array(
	'page_title'    => 'Theme General Settings',
	'menu_title'    => 'Theme Settings',
	'menu_slug'     => 'theme-general-settings',
	'capability'    => 'edit_posts',
	'redirect'      => false,
));

/* set body class based on page family */

function vna_set_body_class( $classes ) {
	$field = get_field( 'page_topic' );
	if ( ! $field ) {
		return $classes;
	}
	switch( $field ) {
		case 'About':
			$classes[] = 'page_about';
			break;
		case 'News':
			$classes[] = 'page_news';
			break;
		case 'Grants':
			$classes[] = 'page_grants';
			break;
		default:
			break;
	}
	return $classes;
}
add_filter( 'body_class', 'vna_set_body_class' );
