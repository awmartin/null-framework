<?php
function NullExcerpt() {
    echo _NullExcerpt();
    }

function _NullExcerpt($attr=null) {

    global $more;
    $original_more = $more;
    $more = 0;
    
    $excerpt = get_the_content("");
    $excerpt = trim($excerpt);
    $excerpt = apply_filters('the_content', $excerpt);
    $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
    $more = $original_more;
    
    if (hasThumbnail()) {
        $class = "excerpt";
        }
    else {
        $class = "excerpt no-thumbnail";
        }
    
    $attr = array('class' => $class);
    return NullTag('div', $excerpt, $attr);
}

function _NullContentWithoutExcerpt($append="") {
    global $more;
    $original_more = $more;
    $more = 1;
    
    $content = get_the_content('', true);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    
    $section = NullStack(array($content), 'section', array('class' => 'post-content clearfix'));

    $more = $original_more;

    $toAppend = NullTag('div', $append);
    return NullTag('div', $section.$toAppend, array('id' => 'content-main', 'class' => 'row'));
}

?>
