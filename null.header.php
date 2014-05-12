<?php

// Captures the contents Wordpress get_header() method.
function NullHeader() {
    ob_start();
    get_header();
    $header = ob_get_contents();
    ob_end_clean();

    return $header;
}

?>