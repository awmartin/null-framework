<?php

function NullContentOnly($content, $layout_class='threeup') {
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

function NullSidebarContent($sidebar, $content, $layout_class='threeup') {
    $contentAttr = array(
        'class' => 'post-group-content'
        );
    $outerContent = NullTag('div', $content, $contentAttr);

    $attr = array(
        'class' => $layout_class.' post-group withsidebar row'
        );

    $contentAndSidebar = NullStack(
        array($sidebar, $outerContent),
        'div',
        $attr
        );

    $mainAttr = array('id' => 'content', 'class' => 'content', 'role' => 'main');
    return NullTag('main', $contentAndSidebar, $mainAttr);
}

function NullOnePage($menu, $panel, $content) {
    $contentAttr = array(
        'class' => 'post-group-content'
        );
    $outerContent = NullTag('div', $content, $contentAttr);
    
    $mainAttr = array('id' => 'content', 'class' => 'content', 'role' => 'main');
    return NullTag('main', $menu.$panel.$outerContent, $mainAttr);
}

?>
