<?php
/**
 * LQ Berita functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package LQ Berita
 */


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function berita_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on LQ Berita, use a find and replace
		* to change 'lq-berita' to the name of your theme in all the template files.
	*/	
	load_theme_textdomain( 'lq-berita', get_template_directory() . '/languages' );
	
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
			'primary' => esc_html__( 'Primary', 'lq-berita' ),
			'mobile'  => esc_html__( 'Mobile Navigation', 'lq-berita' ),
			'footer'  => esc_html__( 'Footer Navigation', 'lq-berita' ),
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
			'berita_custom_background_args',
			array(
				'default-color' => 'f8f8f8',
				'default-image' => '',
			)
		)
	);

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	$editor_stylesheet_path = './style-editor.css';
	// Enqueue editor styles.
	add_editor_style( $editor_stylesheet_path );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

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
add_action( 'after_setup_theme', 'berita_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function berita_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'berita_content_width', 720 );
}
add_action( 'after_setup_theme', 'berita_content_width', 0 );

// Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';

// Block Styles.
require get_template_directory() . '/inc/block-styles.php';
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function berita_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'lq-berita' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'lq-berita' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer One', 'lq-berita' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'lq-berita' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Two', 'lq-berita' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here.', 'lq-berita' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'berita_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function berita_scripts() {
	wp_enqueue_style( 'berita-style', get_stylesheet_uri(), array(), '2.0.4', 'all' );
	wp_style_add_data( 'berita-style', 'rtl', 'replace' );

	wp_enqueue_script( 'berita-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '2.0.4', 'all' );
	wp_enqueue_script( 'berita-js-script' );
	wp_enqueue_script( 'berita-logger', get_template_directory_uri() . '/js/logger.js', array(), '1.0.0', 'all' );
	wp_enqueue_script( 'berita-js-script' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'berita_scripts' );

function berita_my_search_form( $form ) {
	$form = '<form method="get" class="search-modul-home" action="' . esc_url( home_url( '/' ) ) . '">
				<input class="searchTerm" type="text" name="s" placeholder="' . esc_html__( 'Search for news', 'lq-berita' ) . '" style="width: 100%;"/>
					<button type="submit" class="searchButton"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></g></svg></button>
			</form>';

	return $form;
}
add_filter( 'get_search_form', 'berita_my_search_form' );


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

/**
 * Customizer additions.
 *
 * @since 1.0
 */
require get_template_directory() . '/inc/berita-customizer-library.php';
require get_template_directory() . '/inc/lqbtheme-customizer.php';
/**
 * Load Widget class.
 */
require get_template_directory() . '/inc/berita-mostview-widget.php';