<?php
function NullBreadcrumb($options=array()) {
  $tr = '<div class="breadcrumb">';

  if (array_key_exists('before', $options)) :
    $tr .= $options['before'];
  endif;

  $tr .= '<ul class="crumbs">';

  if (array_key_exists('first', $options)) :
    $tr .= '<li class="crumb">';
    $tr .= $options['first'];
    $tr .= '</li>';
  endif;

  if (is_single()) :
    $tr .= list_breadcrumb_categories();
  elseif (is_page()) :
    $tr .= list_breadcrumb_hierarchy();
  else:
  endif;

  $tr .= crumb(home_link());

  if (array_key_exists('last', $options)) :
    $tr .= '<li class="crumb">';
    $tr .= $options['last'];
    $tr .= '</li>';
  endif;

  $tr .= '</ul>';

  if (array_key_exists('after', $options)) :
    $tr .= $options['after'];
  endif;

  return $tr . '</div>';
}

// Manually create a breadcrumb.
function NullBuildBreadcrumb() {
  $args = func_get_args();

  $crumbs = '<ul class="crumbs">';
  foreach ($args as $arg) {
      $crumbs = $crumbs.crumb($arg);
  }

  return $crumbs.'</ul>';
}

function crumb($content) {
    return NullTag("li", $content, array('class' => 'crumb'));
}

function this_link() {

}

function home_link() {
  return NullLink("Home", get_site_url());
}

function list_breadcrumb_categories() {
  $category_list = trim(get_the_category_list( ', ' ));
  if ($category_list != "") {
    return crumb($category_list);
  } else {
    return "";
  }
}

function list_breadcrumb_hierarchy() {
  $tr = "";
  $id = get_the_ID();
  $parent_id = get_post_field('post_parent', $id);

  while ($parent_id > 0) {
    $parent_title = get_the_title($parent_id);
    $parent_url = get_permalink($parent_id);

    $tr .= crumb(NullLink($parent_title, $parent_url));

    $parent_id = get_post_field('post_parent', $parent_id);
  }

  return $tr;
}
?>
