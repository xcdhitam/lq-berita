<<<<<<< HEAD
<?php
/**
 * Block Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 *
	 * @since 2.0.2
	 *
	 * @return void
	 */
	function lq_berita_register_block_styles() {
		// Cover: Borders.
		register_block_style(
			'core/cover',
			array(
				'name'  => 'lq-berita-border',
				'label' => esc_html__( 'Borders', 'lq-berita' ),
			)
		);

		// Group: Borders.
		register_block_style(
			'core/group',
			array(
				'name'  => 'lq-berita-border',
				'label' => esc_html__( 'Borders', 'lq-berita' ),
			)
		);

		// Image: Borders.
		register_block_style(
			'core/image',
			array(
				'name'  => 'lq-berita-border',
				'label' => esc_html__( 'Borders', 'lq-berita' ),
			)
		);

		// Image: Frame.
		register_block_style(
			'core/image',
			array(
				'name'  => 'lq-berita-image-frame',
				'label' => esc_html__( 'Frame', 'lq-berita' ),
			)
		);
	}
	add_action( 'init', 'lq_berita_register_block_styles' );
}
=======
<?php
/**
 * Block Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 *
	 * @since 2.0.2
	 *
	 * @return void
	 */
	function lq_berita_register_block_styles() {
		// Cover: Borders.
		register_block_style(
			'core/cover',
			array(
				'name'  => 'lq-berita-border',
				'label' => esc_html__( 'Borders', 'lq-berita' ),
			)
		);

		// Group: Borders.
		register_block_style(
			'core/group',
			array(
				'name'  => 'lq-berita-border',
				'label' => esc_html__( 'Borders', 'lq-berita' ),
			)
		);

		// Image: Borders.
		register_block_style(
			'core/image',
			array(
				'name'  => 'lq-berita-border',
				'label' => esc_html__( 'Borders', 'lq-berita' ),
			)
		);

		// Image: Frame.
		register_block_style(
			'core/image',
			array(
				'name'  => 'lq-berita-image-frame',
				'label' => esc_html__( 'Frame', 'lq-berita' ),
			)
		);
	}
	add_action( 'init', 'lq_berita_register_block_styles' );
}
>>>>>>> b9cdf76 (initial commit)
