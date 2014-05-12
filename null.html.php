<?php
function NullLink($text, $url, $class="") {
    return NullTag('a', $text, array('href' => $url, 'class' => $class));
}

function NullTag($tag, $content="", $attr=array()) {
    $start = "<".$tag;
    foreach ($attr as $name => $value) {
        $start = $start." ".$name."=\"".$value."\"";
    }
    $start = $start.">";
    $end = "</".$tag.">";
    return $start.$content.$end;
}

function NullFlag($flag, $attr=array()) {
    $start = "<".$flag;
    foreach ($attr as $name => $value) {
        $start = $start." ".$name."=\"".$value."\"";
    }
    $end = ">";
    return $start.$end;
}

function NullClear(){
    return NullTag('div', "", array('class' => 'clear'));
}

function NullHeaderClear(){
    return NullTag('div', "", array('class' => 'header-clear'));
}
?>