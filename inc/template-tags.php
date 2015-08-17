<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Chuchadon
 */
 
if ( ! function_exists( 'chuchadon_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since 1.0.0
 */
function chuchadon_comment_nav( $class= '' ) {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation <?php echo esc_attr( $class ); ?>" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'chuchadon' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( __( '&larr; Older Comments', 'chuchadon' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( __( 'Newer Comments &rarr;', 'chuchadon' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'chuchadon_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 1.0.0
 */
function chuchadon_posted_on() {

	/* Set up entry date. */
	printf( '<span class="entry-date"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s"' . hybrid_get_attr( 'entry-published' ) . '>%4$s</time></a></span>',
		_x( 'Posted on', 'Used before publish date.', 'chuchadon' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	
	/* Set up byline. */
	printf( '<span class="byline"><span class="entry-author" ' . hybrid_get_attr( 'entry-author' ) . '><span class="screen-reader-text">%1$s </span><a class="entry-author-link" href="%2$s" rel="author" itemprop="url"><span itemprop="name">%3$s</span></a></span></span>',
		_x( 'Author', 'Used before post author name.', 'chuchadon' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		get_the_author()
	);

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @since 1.0.0
 * @return bool
 */
function chuchadon_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'chuchadon_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'chuchadon_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so chuchadon_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so chuchadon_categorized_blog should return false.
		return false;
	}
}

/**
 * This template tag is meant to replace template tags like `the_category()`, `the_terms()`, etc.  These core 
 * WordPress template tags don't offer proper translation and RTL support without having to write a lot of 
 * messy code within the theme's templates.  This is why theme developers often have to resort to custom 
 * functions to handle this (even the default WordPress themes do this).  Particularly, the core functions 
 * don't allow for theme developers to add the terms as placeholders in the accompanying text (ex: "Posted in %s"). 
 * This funcion is a wrapper for the WordPress `get_the_terms_list()` function.  It uses that to build a 
 * better post terms list.
 *
 * @author    Justin Tadlock
 * @link      https://github.com/justintadlock/hybrid-core/blob/2.0/functions/template-post.php
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @since  1.0.0
 * @param  array   $args
 * @return string
 */
function chuchadon_get_post_terms( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id'    => get_the_ID(),
		'taxonomy'   => 'category',
		'text'       => '%s',
		'before'     => '',
		'after'      => '',
		'items_wrap' => '<span %s>%s</span>',
		/* Translators: Separates tags, categories, etc. when displaying a post. */
		'sep'        => _x( ', ', 'taxonomy terms separator', 'chuchadon' )
	);

	$args = wp_parse_args( $args, $defaults );

	$terms = get_the_term_list( $args['post_id'], $args['taxonomy'], '', $args['sep'], '' );

	if ( !empty( $terms ) ) {
		$html .= $args['before'];
		$html .= sprintf( $args['items_wrap'], 'class="entry-terms ' . $args['taxonomy'] . '" ' . hybrid_get_attr( 'entry-terms', $args['taxonomy'] ) . '', sprintf( $args['text'], $terms ) );
		$html .= $args['after'];
	}

	return $html;
}

/**
 * Outputs a post's taxonomy terms.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $args
 * @return void
 */
function chuchadon_post_terms( $args = array() ) {
	echo chuchadon_get_post_terms( $args );
}

if ( ! function_exists( 'chuchadon_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since 1.0.0
 */
function chuchadon_post_thumbnail() {
	if ( post_password_required() || is_attachment() ) {
		return;
	}

	if ( has_post_thumbnail() && !is_singular() || is_page_template( 'pages/front-page.php' ) || is_page_template( 'pages/child-pages.php' ) ) : ?>

		<div class="entry-image">
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
				<?php
					the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
				?>
			</a>
		</div><!-- .entry-image -->
		
	<?php endif; // End is_singular()
}
endif;

/**
 * Flush out the transients used in chuchadon_categorized_blog.
 *
 * @since 1.0.0
 */
function chuchadon_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'chuchadon_categories' );
}
add_action( 'edit_category', 'chuchadon_category_transient_flusher' );
add_action( 'save_post',     'chuchadon_category_transient_flusher' );
