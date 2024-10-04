<?php
/**
 * Defines customizer options
 *
 * @package LQ Berita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'berita_get_home' ) ) {
	/**
	 * Get homepage without http/https and www
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function berita_get_home() {
		$protocols = array( 'http://', 'https://', 'http://www.', 'https://www.', 'www.' );
		return str_replace( $protocols, '', home_url() );
	}
}
function lqb_library_options_customizer() {

// Prefix_option.
$lqbprefix = 'lqb';

$header_bgcolor        = '#ffffff';

$upload_dir = wp_upload_dir();

// Stores all the controls that will be added.
$options = array();

// Stores all the sections to be added.
$sections = array();

// Stores all the panels to be added.
$panels = array();

// Adds the sections to the $options array.
$options['sections'] = $sections;

/*
 * Banner
 *
 * @since v.1.0.0
 */

$panel_banner = 'panel-banner';
$panels[]     = array(
    'id'       => $panel_banner,
    'title'    => __( 'Banner', 'lq-berita' ),
    'priority' => '50',
);

$section    = 'bannerundermenu';
$sections[] = array(
    'id'          => $section,
    'title'       => __( 'Banner Under Menu', 'lq-berita' ),
    'priority'    => 15,
    'panel'       => $panel_banner,
    'description' => __( 'Enter the Google AdSense code or other advertising code<br> Example : <br>&lt;img decoding="async" loading="lazy" src="https://lamanqu.com/wp-content/uploads/2023/03/selamat-menjalankan-ibadah-puasa.jpg" alt="banner" class="wp-image-7010"sizes="(max-width: 1024px) 100vw, 1024px" width="1024" height="168"&gt;', 'lq-berita' ),
);

$options[ $lqbprefix . '_undermenu' ] = array(
    'id'          		=> $lqbprefix . '_undermenu',
    'label'      		=> __( 'HTML code.', 'lq-berita' ),
    'section'     		=> $section,
    'type'              => 'textarea',
    'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
    'priority'    		=> 60,
    'description' 		=> __( 'Enter the Google AdSense code or other advertising code', 'lq-berita' ),
);

$section    = 'bannerunderpost';
$sections[] = array(
    'id'          => $section,
    'title'       => __( 'Banner Under Post', 'lq-berita' ),
    'priority'    => 15,
    'panel'       => $panel_banner,
    'description' => __( 'Enter the Google AdSense code or other advertising code<br> Example : <br>&lt;img decoding="async" loading="lazy" src="https://lamanqu.com/wp-content/uploads/2023/03/selamat-menjalankan-ibadah-puasa.jpg" alt="banner" class="wp-image-7010"sizes="(max-width: 1024px) 100vw, 1024px" width="1024" height="168"&gt;', 'lq-berita' ),
);

$options[ $lqbprefix . '_underpost' ] = array(
    'id'          		=> $lqbprefix . '_underpost',
    'label'       		=> __( 'HTML code.', 'lq-berita' ),
    'section'     		=> $section,
    'type'              => 'textarea',
    'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
    'priority'    		=> 60,
    'description' 		=> __( 'Enter the Google AdSense code or other advertising code', 'lq-berita' ),
);


/*
 * Footer Section Options
 *
 * @since v.1.0.0
 */
$panel_footer = 'panel-footer';
$panels[]     = array(
    'id'       => $panel_footer,
    'title'    => __( 'Footer', 'lq-berita' ),
    'priority' => '50',
);

$section    = 'social';
$sections[] = array(
    'id'          => $section,
    'title'       => __( 'Footer Social', 'lq-berita' ),
    'priority'    => 50,
    'panel'       => $panel_footer,
    'description' => __( 'Allow you add social icon.', 'lq-berita' ),
);

$options[ $lqbprefix . '_active-rssicon' ] = array(
    'id'      => $lqbprefix . '_active-rssicon',
    'label'   => __( 'Disable RSS icon in social', 'lq-berita' ),
    'section' => $section,
    'type'    => 'checkbox',
    'default' => 0,
);

$options[ $lqbprefix . '_fb_url_icon' ] = array(
    'id'          => $lqbprefix . '_fb_url_icon',
    'label'       => __( 'FB Url', 'lq-berita' ),
    'section'     => $section,
    'type'        => 'url',
    'description' => __( 'Fill using http:// or https://', 'lq-berita' ),
    'priority'    => 90,
);

$options[ $lqbprefix . '_twitter_url_icon' ] = array(
    'id'          => $lqbprefix . '_twitter_url_icon',
    'label'       => __( 'X Url', 'lq-berita' ),
    'section'     => $section,
    'type'        => 'url',
    'description' => __( 'Fill using http:// or https://', 'lq-berita' ),
    'priority'    => 90,
);

$options[ $lqbprefix . '_instagram_url_icon' ] = array(
    'id'          => $lqbprefix . '_instagram_url_icon',
    'label'       => __( 'Instagram Url', 'lq-berita' ),
    'section'     => $section,
    'type'        => 'url',
    'description' => __( 'Fill using http:// or https://', 'lq-berita' ),
    'priority'    => 90,
);

$options[ $lqbprefix . '_youtube_url_icon' ] = array(
    'id'          => $lqbprefix . '_youtube_url_icon',
    'label'       => __( 'Youtube Url', 'lq-berita' ),
    'section'     => $section,
    'type'        => 'url',
    'description' => __( 'Fill using http:// or https://', 'lq-berita' ),
    'priority'    => 90,
);


$options[ $lqbprefix . '_whatsapp_url_icon' ] = array(
    'id'          => $lqbprefix . '_whatsapp_url_icon',
    'label'       => __( 'WhatsApp URL', 'lq-berita' ),
    'section'     => $section,
    'type'        => 'url',
    'description' => __( 'Fill using http:// or https://', 'lq-berita' ),
    'priority'    => 90,
);

$options[ $lqbprefix . '_tiktok_url_icon' ] = array(
    'id'          => $lqbprefix . '_tiktok_url_icon',
    'label'       => __( 'TikTok URL', 'lq-berita' ),
    'section'     => $section,
    'type'        => 'url',
    'description' => __( 'Fill using http:// or https://', 'lq-berita' ),
    'priority'    => 90,
);

$options[ $lqbprefix . '_telegram_url_icon' ] = array(
    'id'          => $lqbprefix . '_telegram_url_icon',
    'label'       => __( 'Telegram URL', 'lq-berita' ),
    'section'     => $section,
    'type'        => 'url',
    'description' => __( 'Fill using http:// or https://', 'lq-berita' ),
    'priority'    => 90,
);






// Adds the sections to the $options array.
$options['sections'] = $sections;
// Adds the panels to the $options array.
$options['panels']  = $panels;
$customizer_library = Berita_Customizer_Library::Instance();
$customizer_library->add_options( $options );
// To delete custom mods use: customizer_library_remove_theme_mods();.
}
add_action( 'init', 'lqb_library_options_customizer' );
