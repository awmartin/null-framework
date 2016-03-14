<?php

/* Placeholders for future layout methods. */

function NullFullPage($content) {
  return NullSection($content);
}

function NullContentSidebar($content, $sidebar) {
  $layout = '<div class="row">';

    $layout .= '<main class="eight columns">';
    $layout .= $content;
    $layout .= '</main>';

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

    $layout .= '<main class="eight columns">';
    $layout .= $content;
    $layout .= '</main>';

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

function NullContainer($content) {
  return NullTag('div', $content, array('class' => 'container'));
}

function NullMain($content, $options=array()) {
  return NullTag('main',
    NullTag(
      'div',
      $content,
      array('class' => 'container')
    ),
    $options
  );
}

?>
