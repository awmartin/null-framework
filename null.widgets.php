<?php
// Capturing output of 'echo':
// http://www.tequilafish.com/2009/02/10/php-how-to-capture-output-of-echo-into-a-local-variable/
function NullWidgetArea($id) {
    ob_start();
    dynamic_sidebar($id);
    $widgets = ob_get_contents();
    ob_end_clean();
    return $widgets;
}

function NullHorizontalWidgetArea($id) {
  return NullTag("div",
    NullTag("div",
      NullWidgetArea($id),
      array('class' => 'row')
    ),
    array('class' => 'container')
  );
}

function NullMenu($name) {
  return wp_nav_menu(array(
    'theme_location' => $name,
    'echo' => false,
  ));
}
?>
