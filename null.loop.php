<?php
function NullLoop($contentFunction, $noResultsTemplate='archive') {
    echo _NullLoop($contentFunction);
}

// Passing in a function as an argument.
// http://stackoverflow.com/questions/627775/php-pass-function-as-param-then-call-the-function
function _NullLoop($contentFunction, $noResultsTemplate='archive') {
    ob_start();
    
    if (have_posts()):
        while ( have_posts() ) : the_post();

            echo $contentFunction();
            
        endwhile; // end of the loop.
    else:
        get_template_part( 'no-results', $noResultsTemplate );
    endif;
    
    $loopContent = ob_get_contents();
    ob_end_clean();
    
    return $loopContent;
}

function NullComments() {
    ob_start();
    
	// If comments are open or we have at least one comment, load up the comment template
	if ( comments_open() || '0' != get_comments_number() )
		comments_template();
    
    $comments = ob_get_contents();
    ob_end_clean();
    
    return $comments;
}

function NullPagination() {
    echo _NullPagination();
}

function _NullPagination() {
    ob_start();
    plinth_content_nav( 'nav-below' );
    $pagination = ob_get_contents();
    ob_end_clean();
    
    return NullTag(
        'div',
        NullClear().$pagination,
        array('class' => 'pagination row')
    );
}

function NullQuery($posts_per_page=10, $categories=array()) {
    global $wp_query;
    
    $category_ids = array();
    foreach ($categories as $category) {
        $category_ids[] = get_cat_ID($category);
        }
    
    $cat = implode(',', $category_ids);
    
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $wp_query = new WP_Query(
        array( 'posts_per_page' => $posts_per_page, 'cat' => $cat, 'paged' => $paged )
        );
}

function NullIsFirstPage(){
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    return $paged == 1;
}

function NullFeature(){
    NullQuery(1, array('features'));
    echo NullTag(
        'div',
        _NullLoop('NullFeaturedEntry', 'empty')."<hr>",
        array('class' => 'row featured')
        );
}
?>
