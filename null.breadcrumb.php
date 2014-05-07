<?php 
function NullBreadcrumb() {
    $tr = '<ul class="breadcrumb">';
    
    $category_list = trim(get_the_category_list( ', ' ));
    if ($category_list != "") {
        $tr = $tr."<li>&middot; ".get_the_category_list( ', ' )."</li>";
    }
    
    $tr = $tr.'<li>&middot; <a href="'.get_site_url().'">Home</a></li>';
    $tr = $tr.'</ul>';
    return $tr;
    }
?>
