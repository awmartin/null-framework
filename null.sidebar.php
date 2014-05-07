<?php
function NullSidebar($klass="") {
    echo _NullSidebar($klass="");
    }

function _NullSidebar($attr=array()){
    $klass = '';
    $prepend = '';
    $append = '';
    
    if (array_key_exists('class', $attr)) {
        $klass = $attr['class'];
    }
    if (array_key_exists('append', $attr)) {
        $append = $attr['append'];
    }
    if (array_key_exists('prepend', $attr)) {
        $prepend = $attr['prepend'];
    }
    
    $sidebarContent = _NullWidgetArea('Index Right Aside');
    $sidebarAttr = array(
        'id' => 'sidebar',
        'class' => 'widget-area '.$klass,
        'role' => 'complementary'
        );
    return NullTag('aside', $prepend.$sidebarContent.$append, $sidebarAttr);
    }
?>
