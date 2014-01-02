<?php

function NullSearchTitle() {
    echo _NullSearchTitle();
}

function _NullSearchTitle() {
    $title = sprintf( 
        __( 'Search Results for: %s', 'plinth' ),
        '<span>' . get_search_query() . '</span>'
        );
    $attr = array('class' => 'page-title');
    return NullTag('h1', $title, $attr);
}

function _NullSearchHeader() {
    $attr = array('class' => 'page-header');
    return NullTag('header', _NullSearchTitle(), $attr);
}

?>
