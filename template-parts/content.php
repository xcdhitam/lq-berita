<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package LQ Berita
 */

?>
<article id="post-<?php the_ID(); ?>" <?php if ( is_singular() ) : post_class( 'post-content-single' ); else : post_class( 'post-content-list' ); endif; ?> itemscope itemtype="https://schema.org/NewsArticle">

	<?php if ( is_singular() ) : ?>
		
	<header class="content-single-header">
        <?php the_title( '<h2 class="content-single-title" itemprop="headline">', '</h2>' ); ?>
    </header><!-- .entry-header -->
	<?php if ( 'post' === get_post_type() ) : ?>
        <div class="content-single-details">
            <?php berita_post_header(); ?>
        </div><!-- .entry-footer -->
    <?php endif; ?>
    <?php berita_post_thumbnail(); ?>
    	<div class="content-single-entry" itemprop="articleBody">
			<?php $caption = get_post( get_post_thumbnail_id() )->post_excerpt; if ( $caption ) : ?>
				<figcaption class="gambar-caption"><?php echo esc_html( $caption ); ?></figcaption>
				<hr>
			<?php endif; ?>
			<!-- .entry-header -->
			<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'lq-berita' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lq-berita' ),
						'after'  => '</div>',
					)
				);
			?>
		</div><!-- .entry-content -->
		<div class="line-break"></div>
		<footer class="content-single-footer">
			<?php berita_entry_footer(); ?>
		</footer><!-- .entry-footer -->
		<div class="content-single-ads">
            <?php do_action( 'berita_underpost' ); ?>
        </div>
		<div class="content-single-recent">
		    <header class="page-header">
                <?php echo '<h2 class="page-title">Related News</h2>'; ?>
                    
                <?php 
                    echo '<a href="' . esc_url( home_url( '/index' ) ) . '" class="heading-text" title="' . esc_html__( 'News Indeks', 'lq-berita' ) . '">' . esc_html__( 'News Index', 'lq-berita' ) . '</a>';
                ?>
            </header>
            <?php do_action( 'berita_related_post' ) ?>
            <div class="line-break"></div>
        </div>
	<?php 
		else : 
		berita_post_thumbnail();
	?>
	
	<header class="content-list-text">
		<?php the_title( '<h2 class="content-list-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" title="'. $post->post_title .'" rel="bookmark">', '</a></h2>' );  ?>
		<?php berita_content_header(); ?>
	</header><!-- .entry-header -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
