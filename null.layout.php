<?php

/* Placeholders for future layout methods. */

function NullFullPage($content) {
  return $content;
}

function NullContentSidebar($content, $sidebar) {
  return $content.$sidebar;
}

function NullSidebarContent($sidebar, $content) {
  return $sidebar.$content;
}

function NullSection($content) {
  return $content;
}

?>
