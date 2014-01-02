<?php 
function NullBreadcrumb() {
    $tr = '<ul id="breadcrumb">';
    $tr = $tr."<li>&middot; ".get_the_category_list( ', ' )."</li>";
    $tr = $tr.'<li>&middot; <a href="'.get_site_url().'">Home</a></li>';
    $tr = $tr.'</ul>';
    return $tr;
    }
?>
