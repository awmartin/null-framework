<?php
function NullPostedOn() {
    echo _NullPostedOn();
    }

function _NullPostedOn() {
    if (hasThumbnail()) {
        $class = "post-info-custom";
        }
    else {
        $class = "post-info-custom no-thumbnail";
        }
    
    $postedString = get_plinth_posted_on();
    if ($attr == null) {
        $attr = array('class' => $class);
        }
    return NullTag('div', $postedString, $attr);
}

?>