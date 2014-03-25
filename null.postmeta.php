<?php
function NullPostedOn() {
    echo _NullPostedOn();
    }

function _NullPostedOn() {
    if (hasThumbnail()) {
        $class = "post-info-custom style-links";
        }
    else {
        $class = "post-info-custom no-thumbnail style-links";
        }
    
    $postedString = get_plinth_posted_on();
    if ($attr == null) {
        $attr = array('class' => $class);
        }
    
    $posttags = _NullPostTags();
    if ($posttags) {
        $postedString = $postedString.'<ul class="tags">';
        foreach($posttags as $tag) {
            $link = get_tag_link($tag->term_id);
            $name = $tag->name;
            $postedString = $postedString.'<li class="tag"><a href="'.$link.'">'.$name.'</a></li>';
        }
    $postedString = $postedString.'</ul>';
    }
    
    return NullTag('div', $postedString, $attr);
}

function _NullPostTags(){
    $posttags = get_the_tags();
    return $posttags;
}
?>