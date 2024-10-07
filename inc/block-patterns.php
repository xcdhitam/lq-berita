<?php
/**
 * Block Patterns
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_pattern/
 * @link https://developer.wordpress.org/reference/functions/register_block_pattern_category/
 *
 * @package WordPress
 * @subpackage LQ Berita
 * @since 2.0.2
 */

/**
 * Register Block Pattern Category.
 */
if ( function_exists( 'register_block_pattern_category' ) ) {

	register_block_pattern_category(
		'lq-berita',
		array( 'label' => esc_html__( 'LQ Berita', 'lq-berita' ) )
	);
}

/**
 * Register Block Patterns.
 */
if ( function_exists( 'register_block_pattern' ) ) {

	// FullWidth Post Title, date and author.
	register_block_pattern(
		'lq-berita/large-text',
		array(
			'title'         => esc_html__( 'Post Title, Date and Author', 'lq-berita' ),
			'categories'    => array( 'lq-berita' ),
			'viewportWidth' => 1280,
			'content'       => '<!-- wp:query {"queryId":1,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"metadata":{"categories":["lq-berita"],"patternName":"lq-berita/large-text","name":"Fullwidth posts titles with dates"},"align":"full","layout":{"type":"default"}} -->
<div class="wp-block-query alignfull"><!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","right":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-top:0;padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)"><!-- wp:post-template {"align":"full","style":{"typography":{"textTransform":"none"}}} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"0","padding":{"bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-bottom:0"><!-- wp:post-title {"isLink":true,"style":{"layout":{"selfStretch":"fit"},"typography":{"textDecoration":"none","lineHeight":"1.1","fontSize":"13pt","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}},"textColor":"contrast"} /-->

<!-- wp:group {"style":{"border":{"top":{"color":"var:preset|color|contrast","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|0","right":"0","bottom":"var:preset|spacing|20","left":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--contrast);border-top-width:1px;padding-top:var(--wp--preset--spacing--0);padding-right:0;padding-bottom:var(--wp--preset--spacing--20);padding-left:0"><!-- wp:post-date {"textAlign":"left","format":"j F Y","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"letterSpacing":"1px","fontSize":"9pt","fontStyle":"normal","fontWeight":"600"}},"textColor":"contrast"} /-->

<!-- wp:post-author-name {"textAlign":"left","isLink":true,"style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"letterSpacing":"1px","fontSize":"9pt","fontStyle":"normal","fontWeight":"600"}},"textColor":"contrast"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:group --></div>
<!-- /wp:query -->',
		)
	);

	// Small Image, Title and Date.
	register_block_pattern(
		'lq-berita/large-text',
		array(
			'title'         => esc_html__( 'Small Image, Title and Date', 'lq-berita' ),
			'categories'    => array( 'lq-berita' ),
			'viewportWidth' => 1280,
			'content'       => '<!-- wp:query {"queryId":2,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"metadata":{"categories":["posts"],"patternName":"core/query-small-posts","name":"Small image and title"}} --><div class="wp-block-query"><!-- wp:post-template --><!-- wp:columns {"verticalAlignment":"center"} --><div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"25%"} --><div class="wp-block-column is-vertically-aligned-center" style="flex-basis:25%"><!-- wp:post-featured-image {"isLink":true} /--></div><!-- /wp:column --><!-- wp:column {"verticalAlignment":"center","width":"75%","className":"is-vertically-aligned-top"} --><div class="wp-block-column is-vertically-aligned-center is-vertically-aligned-center" style="flex-basis:75%"><!-- wp:post-title {"isLink":true,"style":{"layout":{"selfStretch":"fit"},"typography":{"textDecoration":"none","lineHeight":"1.1","fontSize":"13pt","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}},"textColor":"contrast"} /--><!-- wp:post-date {"textAlign":"left","format":"j F Y","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"letterSpacing":"1px","fontSize":"9pt","fontStyle":"normal","fontWeight":"600"}},"textColor":"contrast"} /--></div><!-- /wp:column --></div><!-- /wp:columns --><!-- /wp:post-template --></div><!-- /wp:query -->',
		)
	);

}