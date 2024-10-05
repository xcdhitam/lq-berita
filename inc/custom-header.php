<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package LQ Berita
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses berita_header_style()
 */
function berita_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'berita_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'width'              => 1280,
				'height'             => 250,
				'flex-height'        => true,
				'wp-head-callback'   => 'berita_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'berita_custom_header_setup' );

if ( ! function_exists( 'berita_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see berita_custom_header_setup().
	 */
	function berita_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
			// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
if ( ! function_exists( 'berita_logo_preview' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see berita_logo_preview().
	 */
	function berita_logo_preview() {
		$html           = '';
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( is_customize_preview() && ! empty( $custom_logo_id ) ) {
			$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
			/* If no logo is set but we're in the Customizer, leave a placeholder (needed for the live preview). */
			$html = sprintf(
				'<a href="%1$s" title="%2$s" rel="home"><img class="custom-logo" src="%3$s" width="%4$s" height="%5$s" alt="%2$s" loading="lazy" /></a>',
				esc_url( home_url( '/' ) ),
				get_bloginfo( 'name', 'display' ),
				esc_url( $logo[0] ), $logo[1], $logo[2]
			);
		} 
		return $html;
	}
endif;
add_filter( 'get_custom_logo', 'berita_logo_preview' );