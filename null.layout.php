<?php

function NullContentOnly($content, $layout_class='threeup') {
    echo _NullContentOnly($content, $layout_class);
}

function _NullContentOnly($content, $layout_class='threeup') {
    $contentAttr = array(
        'class' => 'post-group-content'
        );
    $outerContent = NullTag('div', $content, $contentAttr);

    $attr = array(
        'class' => $layout_class.' post-group row'
        );

    $content = NullTag(
        'div',
        $outerContent,
        $attr
        );
        
    $mainAttr = array('id' => 'content', 'class' => 'home', 'role' => 'main');
    return NullTag('main', $content, $mainAttr);
}

function NullContentSidebar($content, $sidebar, $layout_class='threeup') {
    echo _NullContentSidebar($content, $sidebar, $layout_class);
}

function _NullContentSidebar($content, $sidebar, $layout_class='threeup') {
    $contentAttr = array(
        'class' => 'post-group-content'
        );
    $outerContent = NullTag('div', $content, $contentAttr);

    $attr = array(
        'class' => $layout_class.' post-group withsidebar row'
        );

    $contentAndSidebar = NullStack(
        array($outerContent, $sidebar),
        'div',
        $attr
        );
        
    $mainAttr = array('id' => 'content', 'class' => 'home', 'role' => 'main');
    return NullTag('main', $contentAndSidebar, $mainAttr);
}

function NullSidebarContent($sidebar, $content) {
    echo _NullSidebarContent($sidebar, $content);
}

function _NullSidebarContent($sidebar, $content) {
    return NullStack(
        array($content, $sidebar),
        'div',
        array('id' => 'main', 'class' => 'site-main sidebar-content')
        );
}



?>
