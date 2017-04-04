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

	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Oswald:300,400,600' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_front_page() || is_page_template( 'slideshow-page.php' ) ) {
		wp_enqueue_style( 'flexslider-css', get_stylesheet_directory_uri() . '/flexslider/flexslider.css' );
	}

}
add_action( 'wp_enqueue_scripts', 'vna_scripts' );

function theme_typekit() {
	wp_enqueue_script( 'theme_typekit', 'https://use.typekit.net/fot7alu.js' );
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

function vna_get_recent_posts( $count, $cats = '' ) {
	$args = array(
		'posts_per_page' => $count,
		'post_type' => 'post',
		'orderby' => 'date',
		'order' => 'DESC',
		'post_status' => array( 'publish' ),
	);
	if ( '' != $cats ) {
		$args['category_name'] = $cats;
	}
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
	switch ( $field ) {
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

/**
 * get youtube video ID from URL
 *
 * @param string $url
 * @return string Youtube video id or FALSE if none found.
 */
function youtube_id_from_url( $url ) {
	$video_id = false;
	$url = parse_url( $url );
	if ( strcasecmp( $url['host'], 'youtu.be' ) === 0 ) {
		#### (dontcare)://youtu.be/<video id>
		$video_id = substr( $url['path'], 1 );
	} elseif ( strcasecmp( $url['host'], 'www.youtube.com' ) === 0 ) {
		if ( isset( $url['query'] ) ) {
			parse_str( $url['query'], $url['query'] );
			if ( isset( $url['query']['v'] ) ) {
				#### (dontcare)://www.youtube.com/(dontcare)?v=<video id>
				$video_id = $url['query']['v'];
			}
		}
		if ( $video_id == false ) {
			$url['path'] = explode( '/', substr( $url['path'], 1 ) );
			if ( in_array( $url['path'][0], array( 'e', 'embed', 'v' ) ) ) {
				#### (dontcare)://www.youtube.com/(whitelist)/<video id>
				$video_id = $url['path'][1];
			}
		}
	}
	return $video_id;
}


/**
 * Grants Management stuff
 */
	// Register Custom Post Type
function vna_grant() {

		$labels = array(
	  'name'                  => _x( 'Grants', 'Post Type General Name', 'vna' ),
	  'singular_name'         => _x( 'Grant', 'Post Type Singular Name', 'vna' ),
	  'menu_name'             => __( 'Grants', 'vna' ),
	  'name_admin_bar'        => __( 'Grants', 'vna' ),
	  'archives'              => __( 'Grant Archives', 'vna' ),
	  'attributes'            => __( 'Grant Attributes', 'vna' ),
	  'parent_item_colon'     => __( 'Parent Item:', 'vna' ),
	  'all_items'             => __( 'All Grants', 'vna' ),
	  'add_new_item'          => __( 'Add New Grant', 'vna' ),
	  'add_new'               => __( 'Add New', 'vna' ),
	  'new_item'              => __( 'New Grant', 'vna' ),
	  'edit_item'             => __( 'Edit Grant', 'vna' ),
	  'update_item'           => __( 'Update Grant', 'vna' ),
	  'view_item'             => __( 'View Grant', 'vna' ),
	  'view_items'            => __( 'View Grants', 'vna' ),
	  'search_items'          => __( 'Search Grants', 'vna' ),
	  'not_found'             => __( 'Not found', 'vna' ),
	  'not_found_in_trash'    => __( 'Not found in Trash', 'vna' ),
	  'featured_image'        => __( 'Featured Image', 'vna' ),
	  'set_featured_image'    => __( 'Set featured image', 'vna' ),
	  'remove_featured_image' => __( 'Remove featured image', 'vna' ),
	  'use_featured_image'    => __( 'Use as featured image', 'vna' ),
	  'insert_into_item'      => __( 'Insert into item', 'vna' ),
	  'uploaded_to_this_item' => __( 'Uploaded to this item', 'vna' ),
	  'items_list'            => __( 'Items list', 'vna' ),
	  'items_list_navigation' => __( 'Items list navigation', 'vna' ),
	  'filter_items_list'     => __( 'Filter items list', 'vna' ),
	);
	$args = array(
	  'label'                 => __( 'Grant', 'vna' ),
	  'description'           => __( 'VNA Grants', 'vna' ),
	  'labels'                => $labels,
	  'supports'              => array( 'title', 'editor' ),
	  'taxonomies'            => array( 'grant_organizations' ),
	  'hierarchical'          => false,
	  'public'                => true,
	  'show_ui'               => true,
	  'show_in_menu'          => true,
	  'menu_position'         => 5,
	  'menu_icon'             => 'dashicons-admin-multisite',
	  'show_in_admin_bar'     => true,
	  'show_in_nav_menus'     => true,
	  'can_export'            => true,
	  'has_archive'           => true,
	  'exclude_from_search'   => false,
	  'publicly_queryable'    => true,
	  'capability_type'       => 'page',
	);
	register_post_type( 'grant', $args );

}
	add_action( 'init', 'vna_grant', 0 );

	// Register Custom Taxonomy
function vna_grant_organizations() {

	$labels = array(
		'name'                       => _x( 'Organizations', 'Taxonomy General Name', 'vna' ),
		'singular_name'              => _x( 'Organization', 'Taxonomy Singular Name', 'vna' ),
		'menu_name'                  => __( 'Orgnizations', 'vna' ),
		'all_items'                  => __( 'All Organizations', 'vna' ),
		'parent_item'                => __( 'Parent Organization', 'vna' ),
		'parent_item_colon'          => __( 'Parent Organization:', 'vna' ),
		'new_item_name'              => __( 'New Organization', 'vna' ),
		'add_new_item'               => __( 'Add New Organization', 'vna' ),
		'edit_item'                  => __( 'Edit Organization', 'vna' ),
		'update_item'                => __( 'Update Organization', 'vna' ),
		'view_item'                  => __( 'View Organization', 'vna' ),
		'separate_items_with_commas' => __( 'Separate organizations with commas', 'vna' ),
		'add_or_remove_items'        => __( 'Add or remove organizations', 'vna' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'vna' ),
		'popular_items'              => __( 'Popular Items', 'vna' ),
		'search_items'               => __( 'Search Items', 'vna' ),
		'not_found'                  => __( 'Not Found', 'vna' ),
		'no_terms'                   => __( 'No items', 'vna' ),
		'items_list'                 => __( 'Items list', 'vna' ),
		'items_list_navigation'      => __( 'Items list navigation', 'vna' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'grant_organizations', array( 'grant' ), $args );

}
add_action( 'init', 'vna_grant_organizations', 0 );
// Register Custom Taxonomy
function vna_grant_award_dates() {

	$labels = array(
		'name'                       => _x( 'Award Dates', 'Taxonomy General Name', 'vna' ),
		'singular_name'              => _x( 'Award Date', 'Taxonomy Singular Name', 'vna' ),
		'menu_name'                  => __( 'Award Dates', 'vna' ),
		'all_items'                  => __( 'All Award Dates', 'vna' ),
		'parent_item'                => __( 'Parent Award Date', 'vna' ),
		'parent_item_colon'          => __( 'Parent Award Date:', 'vna' ),
		'new_item_name'              => __( 'New Award Date', 'vna' ),
		'add_new_item'               => __( 'Add New Award Date', 'vna' ),
		'edit_item'                  => __( 'Edit Award Date', 'vna' ),
		'update_item'                => __( 'Update Award Date', 'vna' ),
		'view_item'                  => __( 'View Award Date', 'vna' ),
		'separate_items_with_commas' => __( 'Separate Award Dates with commas', 'vna' ),
		'add_or_remove_items'        => __( 'Add or remove organizations', 'vna' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'vna' ),
		'popular_items'              => __( 'Popular Items', 'vna' ),
		'search_items'               => __( 'Search Items', 'vna' ),
		'not_found'                  => __( 'Not Found', 'vna' ),
		'no_terms'                   => __( 'No items', 'vna' ),
		'items_list'                 => __( 'Items list', 'vna' ),
		'items_list_navigation'      => __( 'Items list navigation', 'vna' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'grant_award_dates', array( 'grant' ), $args );

}
add_action( 'init', 'vna_grant_award_dates', 0 );

/*
 * returns the URL for the most recently awarded grants
 * for use on the menu
 */
 
function vna_get_recent_grants() {
	$terms = get_terms( array(
    'taxonomy' => 'grant_award_dates',
    'hide_empty' => true,
		'orderby' => 'title',
		'order' => 'DESC',
		number => 1,
) );
  return  esc_url( home_url( '/' ) ) . 'grant_award_dates/' . $terms[0]->slug . '/';
}
add_shortcode ('recent-grants', 'vna_get_recent_grants' );
