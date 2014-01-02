<?php
    
    function NullHeader() {
        echo _NullHeader();
    }
    
    function _NullHeader() {
        ob_start();
        get_header();
        $header = ob_get_contents();
        ob_end_clean();
    
        return $header;
    }
?>