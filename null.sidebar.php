<?php

// Returns an <aside> tag containing the main navigation.
function NullSidebar($attr=array()){
    $klass = '';
    $id = 'main-sidebar';
    $prepend = '';
    $append = '';
    $widgetArea = 'Navigation';

    if (array_key_exists('class', $attr)) {
        $klass = $attr['class'];
    }
    if (array_key_exists('append', $attr)) {
        $append = $attr['append'];
    }
    if (array_key_exists('prepend', $attr)) {
        $prepend = $attr['prepend'];
    }
    if (array_key_exists('widgetArea', $attr)) {
        $widgetArea = $attr['widgetArea'];
    }
    if (array_key_exists('id', $attr)) {
      if ($attr['id'] != "") {
        $id = $attr['id'];
      }
    }

    $sidebarContent = NullWidgetArea($widgetArea);
    $sidebarAttr = array(
        'id' => $id,
        'class' => 'sidebar widget-area '.$klass
        );
    return NullTag('aside', $prepend.$sidebarContent.$append, $sidebarAttr);
    }
?>
