<?php
function NullSidebar() {
    echo _NullSidebar();
    }

function _NullSidebar(){
    $sidebarContent = _NullWidgetArea('Index Right Aside');
    $sidebarAttr = array(
        'id' => 'sidebar',
        'class' => 'widget-area',
        'role' => 'complementary'
        );
    return NullTag('aside', $sidebarContent, $sidebarAttr);
    }
?>