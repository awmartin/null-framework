<?php
// Notes: How to extract function arguments.
// func_num_args(), func_get_arg(), and func_get_args()

function _NullPostHeader() {
    return renderHeader(func_get_args());
    }

function NullPostHeader() {
    echo renderHeader(func_get_args());
    }

function renderHeader($args) {
    return NullStack($args, 'header', array('class' => 'post-header'));
    }

function NullStack($args, $tag, $attr) {
    $tr = "";
    foreach ($args as $arg) {
        $tr = $tr.$arg;
        }
    return NullTag($tag, $tr, $attr);
    }

function NullContent($more=false) {
    echo _NullContent($more);
    }
    
function _NullContent($more=false) {
    $content = array(
        NullPostContent($more)
        );
    $section = NullStack(
        $content, 
        'section', 
        array('class' => 'post-content clearfix')
        );
    return $section;

    // return NullTag('div', $section, array('class' => 'content-body row'));
}

// Temporary solution to the content-sidebar, sidebar-content layout problem.
function NullContentBody($more=false, $widgetArea='Post Sidebar'){
    $content = _NullContent($more);
    $sidebar = NullPostSidebar($widgetArea);
    
    return NullTag(
        'div',
        $content.$sidebar,
        array('class' => 'content-body row')
        );
}

function NullPostSidebar($widgetArea='Post Sidebar') {
    $sidebar = _NullWidgetArea($widgetArea);
    return NullTag(
        'aside',
        $sidebar,
        array('class' => 'post-sidebar')
    );
}

function NullPostContent($more=false) {
    if ($more) {
        return get_post_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'plinth' ) );
    } else {
        return get_post_content();
    }
}

function get_post_content($more_link_text = null, $stripteaser = false){
    // Emulates the_content() without being stupid.
    $content = get_the_content($more_link_text, $stripteaser);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}

function NullPostPagination() {
    $attr = array(
        'before' => '<div class="page-links row">' . __( 'Pages:', 'plinth' ),
        'after' => '</div>',
        'echo' => 0
        );
    return wp_link_pages($attr);
    }

function NullPostFooter(){
    echo _NullPostFooter();
}

function _NullPostFooter() {
	/* translators: used between list items, there is a space after the comma */
	$category_list = get_the_category_list( __( ', ', 'plinth' ) );

	/* translators: used between list items, there is a space after the comma */
	$tag_list = get_the_tag_list( '', __( ', ', 'plinth' ) );

	if ( ! plinth_categorized_blog() or !is_post()) {
		// This blog only has 1 category so we just need to worry about tags in the meta text
		if ( '' != $tag_list ) {
			$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'plinth' );
		} else {
			$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'plinth' );
		}

	} else {
		// But this blog has loads of categories so we should probably display them here
		if ( '' != $tag_list ) {
			$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'plinth' );
		} else {
			$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'plinth' );
		}

	} // end check for categories on this blog

	$content = sprintf(
		$meta_text,
		$category_list,
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	    );
    
    $edit_link = _NullEditPostLink();
    $content = $content.$edit_link;
    
    $attr = array('class' => 'entry-meta');
    return NullTag('footer', $content, $attr);
}

function NullEditPostLink(){
    echo _NullEditPostLink();
}

function _NullEditPostLink() {
    return return_edit_post_link(
            __( 'Edit', 'plinth' ),
            '<span class="edit-link">',
            '</span>'
            );
}

function return_edit_post_link( $link = null, $before = '', $after = '', $id = 0 ) {
    if ( !$post = get_post( $id ) )
            return;

    if ( !$url = get_edit_post_link( $post->ID ) )
            return;

    if ( null === $link )
            $link = __('Edit This');

    $post_type_obj = get_post_type_object( $post->post_type );
    $link = '<a class="post-edit-link" href="' . $url . '" title="' . esc_attr( $post_type_obj->labels->edit_item ) . '">' . $link . '</a>';
    return $before . apply_filters( 'edit_post_link', $link, $post->ID ) . $after;
}

function NullArticle() {
    $args = func_get_args();
    echo renderArticle($args);
}

function _NullArticle() {
    $args = func_get_args();
    return renderArticle($args);
}

function renderArticle($args) {
    $attr = array(
        'class' => implode(" ", get_post_class())
        );
    
    $contentArgs = array();
    $attrArgs = array();
    foreach ($args as $arg) {
        if (is_array($arg)) {
            $attrArgs[] = $arg;
        } else {
            $contentArgs[] = $arg;
        }
    }
    
    foreach ($attrArgs as $attrArg) {
        foreach ($attrArg as $key => $value) {
            if (array_key_exists('class', $attr)) {
                $attr[$key] = $attr[$key]." ".$value;
            } else {
                $attr[$key] = $value;
            }
        }
    }
    
    return NullStack($contentArgs, 'article', $attr);
}



function is_post(){
    return 'post' == get_post_type();
}

function sep(){
    return NullTag('span', ' | ', array('class' => 'sep'));
}

function NullReadMoreLink() {
    return NullTag('p', NullLink('Read more...', get_permalink()), array('class' => 'read-more'));
}

?>
