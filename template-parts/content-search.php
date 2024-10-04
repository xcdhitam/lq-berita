<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package LQ Berita
 */

?>
<article id="post-<?php the_ID(); ?>" <?php if ( is_singular() ) : post_class( 'post-content-single' ); else : post_class( 'post-content-list' ); endif; ?> itemscope itemtype="https://schema.org/NewsArticle">
	<?php berita_post_thumbnail();	?>
	
	<header class="content-list-text">
		<?php the_title( '<h2 class="content-list-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" title="'. $post->post_title .'" rel="bookmark">', '</a></h2>' );  ?>
		<?php berita_content_header(); ?>
	</header><!-- .entry-header -->
</article>
