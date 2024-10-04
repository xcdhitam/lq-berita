<?php
/**
 * The template for displaying author pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package LQ Berita
 */

get_header();
?>

<div class="wrapper">
    
	<main id="primary" class="site-main">
		<?php if ( have_posts() ) { ?>

			<div class="author-box">
				<div class="author-title">
                    <?php
						/*
						 * Queue the first post, that way we know what author
						 * we're dealing with (if that is the case).
						 *
						 * We reset this later so we can run the loop properly
						 * with a call to rewind_posts().
						 */
						the_post();

						/* translators: %s: Author display name. */
						printf( __( 'Author %s', 'lq-berita' ), get_the_author() );
					?>
				</div>
				<?php if ( get_the_author_meta( 'description' ) ) : ?>
				<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
				<?php endif; ?>
                <div class="author-description">Contribution Amount : <?php echo number_format_i18n( get_the_author_posts() ); ?> Posts</div>
			</div>
			<?php
            rewind_posts();
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

		}else {

		get_template_part( 'parts/content', 'none' );

		}
		?>
	

	</main><!-- #main -->
	
	<aside class="aside aside-2"> 
        <?php get_sidebar(); ?>
	</aside>
</div>
<?php get_footer(); ?>

