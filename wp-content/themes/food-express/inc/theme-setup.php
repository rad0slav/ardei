<?php
/**
 * Food Express Theme Setup.
 *
 * @package Food Express
 */





if ( ! function_exists( 'food_express_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function food_express_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Food Express, use a find and replace
	 * to change 'food-express' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'food-express', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Theme support for post excerpts
	function food_express_add_excerpts_to_pages() {
	     add_post_type_support( 'page', 'excerpt' );
	}
	add_action( 'init', 'food_express_add_excerpts_to_pages' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'food-express-latest-post-img', 550, 306, true );
	add_image_size( 'food-express-featured-image', 1900, 450, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'food-express' ),
		'social'	=> esc_html__( 'Social', 'food-express' ),
	) );

	// Customize the output of the social menu
	function food_express_get_social_menu() {
    if ( has_nav_menu( 'social' ) ) :
			wp_nav_menu( 	array(
					'theme_location'  => 'social',
					'container'       => 'div',
					'container_id'    => 'menu-social',
					'container_class' => 'menu-social four columns',
					'menu_id'         => 'menu-social-items',
					'menu_class'      => 'menu-items text-right',
					'depth'           => 1,
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
					'fallback_cb'     => '',
			));
    endif;
	}

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'food_express_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Set up the WordPress custom logo feature.
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	// Add customizer selective refresh
	add_theme_support( 'customize-selective-refresh-widgets' );

}
endif;
add_action( 'after_setup_theme', 'food_express_setup' );


/**
 * Enables user customization via WordPress plugin API.
 */
require get_template_directory() . '/inc/homepage/functions.php';
require get_template_directory() . '/inc/homepage/hooks.php';

/* Integrate the restaurant-reservations plugin */
require_once get_template_directory() . '/inc/integrations/restaurant-reservations.php' ;

/**
 * Load plugin enhancement file to display admin notices.
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/plugin-enhancements.php';
add_action( 'tgmpa_register', 'food_express_register_required_plugins' );


/**
 * Create Welcome page and redirect to it on theme activation.
 */
if ( is_admin() ) {
	require get_template_directory() . '/inc/admin/welcome-screen/welcome-screen.php';
}


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function food_express_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'food_express_content_width', 640 );
}
add_action( 'after_setup_theme', 'food_express_content_width', 0 );
