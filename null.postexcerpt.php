<?php


function NullExcerpt($attr=null) {

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

function NullContentWithoutExcerpt($append="") {
    global $more;
    $original_more = $more;
    $more = 1;
    
    $content = get_the_content('', true);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    
    $section = NullStack(array($content), 'section', array('class' => 'post-content clearfix'));

    $more = $original_more;

    $toAppend = NullTag('div', $append);
    return NullTag('div', $section.$toAppend, array('class' => 'content-body row'));
}

function NullFirstParagraph($asExcerpt=true) {
    $excerpt = NullExcerpt();
    $first_paragraph = getTextBetweenTags($excerpt, 'p');

    if (!$asExcerpt) {
        return $first_paragraph;
    }
    
    if (hasThumbnail()) {
        $class = "excerpt";
        }
    else {
        $class = "excerpt no-thumbnail";
        }
    
    $attr = array('class' => $class);
    return NullTag('div', NullTag('p', $first_paragraph), $attr);
}

function getTextBetweenTags($string, $tagname) {
    $pattern = "/<$tagname\s?[^>]*?>([\w\W]*?)<\/$tagname>/";
    preg_match($pattern, $string, $matches);
    return $matches[1];
}

function NullContentWithoutFirstParagraph() {
    $content = NullContent();
    return str_replace(NullFirstParagraph(false), "", $content);
}
?>
