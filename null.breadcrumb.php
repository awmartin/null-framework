<?php 
function NullBreadcrumb() {
    $tr = '<ul class="breadcrumb">';
    
    if (is_post()) {
        $tr = $tr.list_breadcrumb_categories();
    } else if (is_page()) {
        $tr = $tr.list_breadcrumb_hierarchy();
    }
    

    
    $tr = $tr.crumb(home_link());
    $tr = $tr.'</ul>';
    
    return $tr;
}

function crumb($content) {
    return NullTag("li", "&middot; ".$content);
}

function home_link() {
    return NullLink("Home", get_site_url());
}

function list_breadcrumb_categories() {
    
    $category_list = trim(get_the_category_list( ', ' ));
    if ($category_list != "") {
        return crumb($category_list);
    } else {
        return "";
    }
}

function list_breadcrumb_hierarchy() {
    $id = get_the_ID();
    $parent_id = get_post_field('post_parent', $id);
    
    if ($parent_id > 0) {
        $parent_title = get_the_title($parent_id);
        $parent_url = get_permalink($parent_id);
        
        return crumb(NullLink($parent_title, $parent_url));
    } else {
        return '';
    }
}
?>
