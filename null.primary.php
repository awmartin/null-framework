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

?>
