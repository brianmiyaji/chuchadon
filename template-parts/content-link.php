<?php
/**
 * The template for displaying link post format content.
 *
 * @package Chuchadon
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php hybrid_attr( 'post' ); ?>>

	<?php chuchadon_post_thumbnail(); ?>

	<div class="entry-inner">
	
		<header class="entry-header">
		
			<?php get_template_part( 'entry', 'meta' ); // Loads the entry-meta.php template. ?>
	
			<?php
			/* Arrow for right to left. */
			if( is_rtl() ) :
				$chuchadon_left_or_right = _x( '&larr;', 'Arrow for link post format in right to left languages', 'chuchadon' );
			else :
				$chuchadon_left_or_right = _x( '&rarr;', 'Arrow for link post format in left to right languages', 'chuchadon' );
			endif;
			?>
		
			<?php if ( is_single() ) : // If viewing a single post.
				$heading = 'h1';
			else : // If not viewing a single post.
				$heading = 'h2';
			endif; // End single post check. ?>
		
			<<?php echo $heading; ?> class="entry-title" <?php echo hybrid_get_attr( 'entry-title' ); ?>>
				<a href="<?php echo esc_url( chuchadon_get_link_url() ); ?>"><?php the_title(); ?> <span class="meta-nav"><?php echo esc_attr( $chuchadon_left_or_right ); ?></span></a>
			</<?php echo $heading; ?>>
		
		</header><!-- .entry-header -->

		<div class="entry-content" <?php hybrid_attr( 'entry-content' ); ?>>
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					__( 'Read more %s', 'chuchadon' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );
			?>
		</div><!-- .entry-content -->

		<?php if ( is_single() ) : // Hide category and tag text for non singular views. ?>
			<footer class="entry-footer">
				<?php chuchadon_post_terms( array( 'taxonomy' => 'category', 'text' => __( 'Posted in %s', 'chuchadon' ) ) ); ?>
				<?php chuchadon_post_terms( array( 'taxonomy' => 'post_tag', 'text' => __( 'Tagged %s', 'chuchadon' ), 'before' => '<br />' ) ); ?>
			</footer><!-- .entry-footer -->
		<?php endif; // End single post check. ?>
		
	</div><!-- .entry-inner -->
	
</article><!-- #post-## -->