<?php

function NullFullWidth($content) {
  $layout = NullTag('div', $content, array('class' => 'row'));

  return NullSection($layout);
}

function NullContentSidebar($content, $sidebar) {
  return NullRow(
    NullTag('div', $content, array('class' => 'eight columns'))
    . NullTag('aside', $sidebar, array('class' => 'four columns'))
    );
}

function NullSidebarContent($sidebar, $content) {
  return NullRow(
    NullTag('aside', $sidebar, array('class' => 'four columns'))
    . NullTag('div', $content, array('class' => 'eight columns'))
    );
}


function NullArticle($content, $options=array()) {
  return NullTag('article', $content, $options);
}

function NullArticleHeader($content, $options=array()) {
  return NullTag('header', $content, $options);
}

function NullArticleFooter($content, $options=array()) {
  return NullTag('footer', $content, $options);
}

function NullSection($content, $options=array()) {
  return NullTag('section', $content, $options);
}

function NullContainer($content) {
  return NullTag('div', $content, array('class' => 'container'));
}

function NullMain($content, $options=array()) {
  return NullTag('main', NullContainer($content), $options);
}

function NullRow($content) {
  return NullTag('div',
    $content,
    array('class' => 'row')
  );
}

function NullColumn($width, $content) {
  return NullTag('div',
    $content,
    array('class' => $width.' columns')
  );
}
?>
