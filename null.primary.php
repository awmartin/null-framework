<?php

function NullPrimary($contentTemplate) {
    echo _NullPrimary($contentTemplate);
}

function _NullPrimary($contentTemplate){
    $primaryContent = NullTag(
        'main',
        _NullLoop($contentTemplate),
        array('id' => 'content-primary')
        );

    $row = NullTag('div', $primaryContent, array('class' => 'row'));

    return NullTag('div', $row, array('id' => 'content', 'class' => 'single'));
}

function NullMain($template) {
    return NullTag(
        'main',
        _NullLoop($template),
        array('class' => 'main')
        );
}

function NullType() {
    if (is_singular()) {
        return 'entry';
    } else {
        return 'collection';
    }
}

function NullBodyClass(){
    $classes = get_body_class();
    $classes[] = NullType();
    return implode(" ", $classes);
}

?>
