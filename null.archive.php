<?php

function NullArchiveTitle(){

	if ( is_category() ) :
		return sprintf( __( '%s', 'plinth' ), '<span>' . single_cat_title( '', false ) . '</span>' );

	elseif ( is_tag() ) :
		return sprintf( __( '%s', 'plinth' ), '<span>' . single_tag_title( '', false ) . '</span>' );

	elseif ( is_author() ) :
		/* Queue the first post, that way we know
		 * what author we're dealing with (if that is the case).
		*/
		the_post();

		return sprintf( __( 'Author Archives: %s', 'plinth' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );

		/* Since we called the_post() above, we need to
		 * rewind the loop back to the beginning that way
		 * we can run the loop properly, in full.
		 */
		rewind_posts();

	elseif ( is_day() ) :
		return sprintf( __( 'Daily Archives: %s', 'plinth' ), '<span>' . get_the_date() . '</span>' );

	elseif ( is_month() ) :
		return sprintf( __( 'Monthly Archives: %s', 'plinth' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

	elseif ( is_year() ) :
		return sprintf( __( 'Yearly Archives: %s', 'plinth' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

	elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
		return __( 'Asides', 'plinth' );


	elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
		return __( 'Images', 'plinth');

	elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
		return __( 'Videos', 'plinth' );

	elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
		return __( 'Quotes', 'plinth' );

	elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
		return __( 'Links', 'plinth' );

	else :
		return __( 'Archives', 'plinth' );

	endif;
}

function NullCategoryDescription() {
    if ( is_category() ) :
    	// show an optional category description
    	$category_description = category_description();
    	if ( ! empty( $category_description ) ) :
    		return apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );
    	endif;
        return "";
    endif;
}


function NullTagDescription() {
    if ( is_tag() ) :
		// show an optional tag description
		$tag_description = tag_description();
		if ( ! empty( $tag_description ) ) :
			return apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
		endif;

        return "";
	endif;
}
?>
