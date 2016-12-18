<?php
/**
 * Template functions used for posts.
 *
 * @package actions
 */

if ( ! function_exists( 'actions_post_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 * @since 1.0.0
	 */
	function actions_post_header() { ?>
		<header class="entry-header">
		<?php
		if ( is_single() ) {			
			the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' );
		} else {
			the_title( sprintf( '<h1 class="entry-title" itemprop="name headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );			
		}
		?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'actions_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 * @since 1.0.0
	 */
	function actions_post_content() { 
	    if ( is_search() ) { ?>		
		
		    <header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'actions' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
			</header><!-- .page-header -->
		
		<?php }
		
		while ( have_posts() ) : the_post(); ?>
		    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		        <?php actions_post_header(); ?>
		        <div class="entry-content">
		        <?php
		            actions_post_thumbnail( 'full' );
		            if ( 'post' == get_post_type() ) { ?>
			            <div class="entry-meta">
			               <?php actions_posted_on(); ?>
			            </div>
	            <?php }

		        if ( is_search() ) {
					the_excerpt();
				} else {
				the_content(
			        sprintf(
				        __( 'Continue reading %s', 'actions' ),
				        '<span class="screen-reader-text">' . esc_url( get_the_title() ) . '</span>'
			        )
		        );
				}
		
		        wp_link_pages( array(
			        'before' => '<div class="page-links">' . __( 'Pages:', 'actions' ),
			        'after'  => '</div>',
		        ) );
		        //actions_entry_footer(); ?>
		        </div><!-- .entry-content -->
		    </article><!-- #post-## -->
        <?php 
		endwhile;		
	}
}

if ( ! function_exists( 'actions_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function actions_paging_nav() {
    // Previous/next page navigation.
		the_posts_pagination( array(
			'prev_text'          => __( 'Previous page', 'actions' ),
			'next_text'          => __( 'Next page', 'actions' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'actions' ) . ' </span>',
		) );
	}
}

if ( ! function_exists( 'actions_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function actions_post_nav() {		
		the_post_navigation( array(
			'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post: ', 'actions' ) . '</span> ' .
				'<span class="screen-reader-text">' . __( 'Next post:', 'actions' ) . '</span> ' .
				'<span class="post-title">%title</span>',
			'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post: ', 'actions' ) . '</span> ' .
				'<span class="screen-reader-text">' . __( 'Previous post:', 'actions' ) . '</span> ' .
				'<span class="post-title">%title</span>',
		) );
	}
}