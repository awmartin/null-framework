<?php
function NullPostTitle() {
    $title = get_the_title();
    $permalink = get_permalink();
    $linkTitleAttr = esc_attr(
                    sprintf( __( 'Permalink to %s', 'plinth' ),
                    the_title_attribute( 'echo=0' )
                    )
                );
    
    $linkAttr = array(
            'title' => $linkTitleAttr,
            'href' => $permalink,
            'rel' => 'bookmark'
            );
    $linkToPost = NullTag('a', $title, $linkAttr);
    
    $headerTitle = NullTag('h1', $linkToPost, array('class' => 'post-title'));
    
    return $headerTitle;
}

?>
