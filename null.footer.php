<?php


function NullFooter(){
    ob_start();
    get_footer();
    $footer = ob_get_contents();
    ob_end_clean();
    return $footer;
}


function NullFooterWrapper($footerContent="") {
    $footerAttr = array(
        'class' => 'container',
        'role' => 'contentinfo'
        );
    
    return NullTag(
        'footer',
        $footerWidgets.$footerContent,
        $footerAttr
        );
}


function NullSubFooter($content){
    return NullTag('div', $content, array('class' => 'footer-content row'));
}

?>