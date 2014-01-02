<?php

function NullFooter(){
    echo _NullFooter();
}

function _NullFooter(){
    ob_start();
    get_footer();
    $footer = ob_get_contents();
    ob_end_clean();
    return $footer;
}


function NullFooterWrapper($subfooterContent="") {
    echo _NullFooterWrapper($subfooterContent);
}

function _NullFooterWrapper($subfooterContent="") {
    $footerContent = NullTag('div', _NullWidgetArea('Footer'), array("class" => "row"));
    
    $footerContent = $footerContent.$subfooterContent;
    
    $footerAttr = array(
        'id' => 'page-footer',
        'class' => 'container',
        'role' => 'contentinfo'
        );
    $footer = NullTag('footer', $footerContent, $footerAttr);
    
    $footer = NullTag('div', $footer, array('id' => 'page-bottom'));
    
    return $footer;
}

function NullSubFooter($content){
    echo _NullSubFooter($content);
}

function _NullSubFooter($content){
    return NullTag('div', $content, array('id' => 'site-footer', 'class' => 'row'));
}

?>