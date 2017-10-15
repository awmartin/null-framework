<?php

// WTF Wordpress? get_bloginfo('template_directory') and get_template_directory() do different things?
function getThisThemeFolder() {
  return get_template_directory();
}

/**
  * $options
  *   'categories' => array('whatever')
  *   'tags' => array('whatever')
  *   'format' => 'all', 'standard'
*/
function NullQuery($posts_per_page=10, $options=array()) {
    global $wp_query;

    $categories = array_key_exists('categories', $options) ? $options['categories'] : array();
    $tags = array_key_exists('tags', $options) ? $options['tags'] : array();
    $post_format = array_key_exists('format', $options) ? $options['format'] : 'all';

    $cat = implode(',', $categories);
    $tag = implode(',', $tags);

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    if ($post_format == 'all') {
      // Standard query to get all posts.
      $wp_query = new WP_Query( array(
        'posts_per_page' => $posts_per_page,
        'category_name' => $cat,
        'tag' => $tag,
        'paged' => $paged
      ));
    } else if ($post_format == 'standard') {
      // If we want standard posts, we have to exclude all the other standard types.
      $wp_query = new WP_Query( array(
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'tax_query' => array( array(
          'taxonomy' => 'post_format',
          'field' => 'slug',
          'terms' => array('post-format-aside', 'post-format-gallery', 'post-format-link',
            'post-format-image', 'post-format-quote', 'post-format-status',
            'post-format-audio', 'post-format-chat', 'post-format-video'),
          'operator' => 'NOT IN'
        ))
      ));
    } else {
      // Here, we want a non-standard post, so query directly against the taxonomy.
      $wp_query = new WP_Query( array(
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'tax_query' => array( array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => 'post-format-'.$post_format
          ))
      ));
    }
}

?>
