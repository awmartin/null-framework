<?php

/* Placeholders for future layout methods. */

function NullFullPage($content) {
  return $content;
}

function NullContentSidebar($content, $sidebar) {
  $layout = '<div class="section"><div class="container"><div class="row">';

    $layout .= '<div class="eight columns">';
    $layout .= $content;
    $layout .= '</div>';

    $layout .= '<aside class="four columns">';
    $layout .= $sidebar;
    $layout .= '</aside>';

  $layout .= '</div></div></div>';

  return $layout;
}

function NullSidebarContent($content, $sidebar) {
  $layout = '<div class="section"><div class="container"><div class="row">';

    $layout .= '<aside class="four columns">';
    $layout .= $sidebar;
    $layout .= '</aside>';

    $layout .= '<div class="eight columns">';
    $layout .= $content;
    $layout .= '</div>';

  $layout .= '</div></div></div>';

  return $layout;
}

function NullSection($content, $options=array()) {
  return NullTag('section',
    NullTag(
      'div',
      $content,
      array('class' => 'container')
    ),
    $options
  );
}

?>
