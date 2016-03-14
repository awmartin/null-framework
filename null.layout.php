<?php

/* Placeholders for future layout methods. */

function NullFullPage($content) {
  return NullSection($content);
}

function NullContentSidebar($content, $sidebar) {
  $layout = '<div class="row">';

    $layout .= '<div class="eight columns">';
    $layout .= $content;
    $layout .= '</div>';

    $layout .= '<aside class="four columns">';
    $layout .= $sidebar;
    $layout .= '</aside>';

  $layout .= '</div>';

  return NullSection($layout);
}

function NullSidebarContent($content, $sidebar) {
  $layout = '<div class="row">';

    $layout .= '<aside class="four columns">';
    $layout .= $sidebar;
    $layout .= '</aside>';

    $layout .= '<div class="eight columns">';
    $layout .= $content;
    $layout .= '</div>';

  $layout .= '</div>';

  return NullSection($layout);
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
