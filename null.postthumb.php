<?php
function hasThumbnail() {
    return function_exists('has_post_thumbnail') && has_post_thumbnail();
}

function NullPostThumbnail($size='medium') {
    echo _NullPostThumbnail($size);
}

function _NullPostThumbnail($size='medium') {
    if (hasThumbnail()) {
        $permalink = get_permalink();
        $thumbnail = get_the_post_thumbnail(get_the_ID(), $size);
        $linkAttr = array('href' => $permalink);
        
        $content = NullTag('a', $thumbnail, $linkAttr);
        $attr = array('class' => 'thumbnail');
        return NullTag('div', $content, $attr);
    } else {
        // $content = "";
        return "";
    }
}
?>