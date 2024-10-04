<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package LQ Berita
 */

get_header();
?>
<div class="wrapper">
    
	<main id="primary" class="site-main">
		<div class="module-post-headline">
            <?php do_action( 'berita_home_post' ) ?>
		</div>	
	    <div class="line-break"><hr></div>
		<header class="page-header">
			<?php echo '<h2 class="page-title">'. esc_html__( 'News Feed', 'lq-berita' ) .'</h2>'; ?>
				
			<?php 
				echo '<a href="' . esc_url( home_url( '/index' ) ) . '" class="heading-text" title="' . esc_html__( 'News Index', 'lq-berita' ) . '">' . esc_html__( 'News Index', 'lq-berita' ) . '</a>';
			?>
		</header>

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;

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
	</aside>

</div>

<?php

get_footer();
