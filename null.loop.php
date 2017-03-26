<?php

function StartRow() {
  return '<div class="row">';
}

function EndRow() {
  return '</div>';
}


$availableColumnWidths = array(
  1 => 'twelve',
  2 => 'six',
  3 => 'four',
  4 => 'three',
  6 => 'two',
  12 => 'one'
);

$widths = array(
  1 => 'one',
  2 => 'two',
  3 => 'three',
  4 => 'four',
  5 => 'five',
  6 => 'six',
  7 => 'seven',
  8 => 'eight',
  9 => 'nine',
  10 => 'ten',
  11 => 'eleven',
  12 => 'twelve'
);


function EntryLayout($layout, $numColumns, $options=array()) {
  global $availableColumnWidths;
  global $widths;

  $columnWidth = $availableColumnWidths[$numColumns];
  $columnWidthClass = $columnWidth." columns";

  $postTitle = NullPostTitle(true);
  $categories = NullPostCategories();
  $permalink = get_permalink();

  $availableContent = array(
    'title' => $postTitle,
    'thumbnail' => NullPostThumbnail('thumbnail', true),
    'featured' => NullFeaturedImage(),
    'linkedfeatured' => hasThumbnail() ? '<a href="'.$permalink.'" class="featured-link">'.NullFeaturedImage().'</a>' : '',
    'categories' => $categories,
    'unlinkedcategories' => NullPostCategories(array('linked' => false)),
    'tags' => NullPostTags(),
    'posted_on' => NullPostedOn(),
    'excerpt' => NullFirstParagraph(),
    'format' => NullPostFormat(),
    'categories+title' => '<div>'.$categories.$postTitle.'</div>'
  );

  $availableContent['titleplus'] =
    $availableContent['categories']
    .$availableContent['title']
    .$availableContent['posted_on']
    .$availableContent['tags'];

  $layoutParts = split('-', $layout);

  $type = $layoutParts[0];

  if ($type == "entry") {
    $orientation = $layoutParts[1];
    $partWidth = $availableColumnWidths[count($layoutParts) - 2];

    $content = '';
    for ($i=2, $len = count($layoutParts); $i < $len; $i++) {
      if (array_key_exists('entry-column-widths', $options)) {
        $partWidth = $widths[$options['entry-column-widths'][$i - 2]];
      }

      if ($orientation == 'horizontal') {
        $content .= '<div class="'.$partWidth.' columns">';
      }

      $item = trim($availableContent[$layoutParts[$i]]);
      if ($item == '') {
        $item = '&nbsp;';
      }
      $content .= $item;

      if ($orientation == 'horizontal') {
        $content .= '</div>';
      }
    }

    $schema = NullPostSchema();
    $attr = array('class' => 'entry');
    if ($orientation == 'vertical') {
      // Apply the width of the entire entry here if we're using a vertical entry layout.
      $attr['class'] .= " ".$columnWidthClass;
    }
    if ($availableContent['format']) {
      $attr['class'] .= " ".$availableContent['format'];
    }
    return NullTag('article', $content.$schema, $attr);

  } else {

    $content = '';
    for ($i=1, $len = count($layoutParts); $i < $len; $i++) {
      $item = trim($availableContent[$layoutParts[$i]]);
      if ($item == '') {
        $item = '';
      }
      $content .= $item;
    }

    $schema = NullPostSchema();

    $attr = array('class' => $type.' '.NullPostCategories(array('html' => false)));
    $attr['data-excerpt'] = NullFirstParagraph(false);

    return NullTag('article', $content.$schema, $attr);
  }
}

// Passing in a function as an argument.
// http://stackoverflow.com/questions/627775/php-pass-function-as-param-then-call-the-function
function NullLoop($layout, $numColumns=1, $options=array()) {
  $noResultsTemplate = 'archive';
  if (array_key_exists('no-results-template', $options)) {
    $noResultsTemplate = $options['no-results-template'];
  }

  ob_start();

  $layoutParts = split('-', $layout);
  $type = $layoutParts[0];

  $currentPost = 0;
  if (have_posts()):
    while (have_posts()):
      if ($type == "entry" && $currentPost % $numColumns == 0) {
        echo StartRow();
      }

      the_post();

      echo EntryLayout($layout, $numColumns, $options);

      if ($type == "entry" && ($currentPost + 1) % $numColumns == 0) {
        echo EndRow();
      }

      $currentPost++;

    endwhile; // end of the loop.
  else:
    get_template_part( 'no-results', $noResultsTemplate );
  endif;

  $loopContent = ob_get_contents();
  ob_end_clean();

  return $loopContent;
}

function NullComments() {
    ob_start();

  // If comments are open or we have at least one comment, load up the comment template
  if ( comments_open() || '0' != get_comments_number() )
    comments_template();

  $comments = ob_get_contents();
  ob_end_clean();

  return $comments;
}


function NullPagination() {
    ob_start();
    plinth_content_nav( 'nav-below' );
    $pagination = ob_get_contents();
    ob_end_clean();

    return $pagination;
}

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
