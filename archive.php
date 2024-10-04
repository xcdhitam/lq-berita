<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package LQ Berita
 */

get_header();
?>
<div class="wrapper">

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h2 class="page-title">Archive Feed</h2>
				
				<?php 
					echo '<a href="' . esc_url( home_url( '/index' ) ) . '" class="heading-text" title="' . esc_html__( 'News Indeks', 'lq-berita' ) . '">' . esc_html__( 'News Indeks', 'lq-berita' ) . '</a>';
				?>
			</header><!-- .page-header -->
			<div class="line-break"><hr></div>

			<div class="archive-box">
				<div class="archive-title">
					<?php the_archive_title( '<h2 class="judul-title">', '</h2>' ); ?>
				</div>
				<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
			</div>

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;

			berita_paging_nav();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

	<aside class="aside aside-2"> 
		<?php get_sidebar(); ?>
	</aside><!-- #slidebar -->

</div>

<?php

get_footer();