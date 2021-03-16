<?php
/**
 * theme-4w4 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package theme-4w4
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'theme_4w4_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function theme_4w4_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on theme-4w4, use a find and replace
		 * to change 'theme-4w4' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'theme-4w4', get_template_directory() . '/languages' );

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
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'theme-4w4' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'theme_4w4_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'theme_4w4_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function theme_4w4_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'theme_4w4_content_width', 640 );
}
add_action( 'after_setup_theme', 'theme_4w4_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function theme_4w4_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'theme-4w4' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'theme-4w4' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'theme_4w4_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function theme4w4_scripts() {
    
    wp_register_style('theme-4w4-style', get_stylesheet_uri(), array(), filemtime(get_template_directory() . "/style.css"), 'all' );
    wp_enqueue_style('theme-4w4-style');
    
    wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Montserrat:wght@300;700&display=swap', false ); 
    wp_style_add_data( 'theme4w4-style', 'rtl', 'replace' );
    wp_enqueue_script( 'theme4w4-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'theme4w4-burger', get_template_directory_uri() . '/js/burger.js', array(), _S_VERSION, true );
    
    wp_register_script( 'theme4w4-carrousel', get_template_directory_uri() . '/js/carrousel.js', array(), filemtime(get_template_directory() . "/js/carrousel.js"), true );
    
    if( is_front_page()){
        wp_enqueue_script( 'theme4w4-carrousel');
    }
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'theme4w4_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/*function extraire_cours($query){
	if ($query->is_category('cours'))
	{
		$query->set('posts_per_page', -1);
		$query->set('orderby', 'title');
		$query->set('order', 'asc');
	}
}
add_action('pre_get_posts','extraire_cours');
*/


function extraire_cours_front_page($query){
	if( !is_admin() && $query->is_front_page() && $query->is_main_query() ){

	$query->set( 'category_name', 'cours' );
	$query->set('posts_per_page', -1 );
	$query->set('meta_key', 'type_de_cours');
	$query->set('orderby', array('meta_value' => 'DESC', 'ttle' => 'ASC'));
	$query->set('order', 'desc');
}
}
add_action('pre_get_posts','extraire_cours_front_page');

