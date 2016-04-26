<?php

function NullFullWidth($content) {
  $layout = NullTag('div', $content, array('class' => 'row'));

  return NullSection($layout);
}

function NullContentSidebar($content, $sidebar) {
  $layout = '<div class="row">';

    $layout .= NullTag('main', $content, array('class' => 'eight columns'));
    $layout .= NullTag('aside', $sidebar, array('class' => 'four columns'));

  $layout .= '</div>';

  return NullSection($layout);
}

function NullSidebarContent($content, $sidebar) {
  $layout = '<div class="row">';

    $layout .= NullTag('aside', $sidebar, array('class' => 'four columns'));
    $layout .= NullTag('main', $content, array('class' => 'eight columns'));

  $layout .= '</div>';

  return NullSection($layout);
}

function NullSection($content, $options=array()) {
  return NullTag('section', NullContainer($content), $options);
}

function NullContainer($content) {
  return NullTag('div', $content, array('class' => 'container'));
}

function NullMain($content, $options=array()) {
  return NullTag('main', NullContainer($content), $options);
}

?>
