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
  $class = $columnWidth." columns";

  $availableContent = array(
    'title' => NullPostTitle(true),
    'thumbnail' => NullPostThumbnail('medium', true),
    'categories' => NullPostCategories(true),
    'tags' => NullPostTags(true),
    'posted_on' => NullPostedOn(),
    'excerpt' => NullFirstParagraph()
  );
  $availableContent['titleplus'] =
    $availableContent['categories']
    .$availableContent['title']
    .$availableContent['posted_on']
    .$availableContent['tags'];

  $layoutParts = split('-', $layout);

  $type = $layoutParts[0];
  $orientation = $layoutParts[1];
  $partWidth = $availableColumnWidths[count($layoutParts) - 2];


  $content = '<div class="row entry">';
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
  $content .= '</div>';


  return $content;
}

function PostLayout($layout) {

}

// Passing in a function as an argument.
// http://stackoverflow.com/questions/627775/php-pass-function-as-param-then-call-the-function
function NullLoop($layout, $numColumns=1, $options=array()) {
  $noResultsTemplate = 'archive';
  if (array_key_exists('no-results-template', $options)) {
    $noResultsTemplate = $options['no-results-template'];
  }

  ob_start();

  // $layoutParts = split('-', $layout);
  // $type = $layoutParts[0];

  $currentPost = 0;
  if (have_posts()):
    while (have_posts()):
      if ($currentPost % $numColumns == 0) {
        echo StartRow();
      }

      the_post();

      echo EntryLayout($layout, $numColumns, $options);

      if (($currentPost + 1) % $numColumns == 0) {
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

    return NullTag(
        'div',
        $pagination
    );
}

function NullQuery($posts_per_page=10, $categories=array(), $tags=array()) {
    global $wp_query;

    $cat = implode(',', $categories);
    $tag = implode(',', $tags);

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $wp_query = new WP_Query( array(
        'posts_per_page' => $posts_per_page,
        'category_name' => $cat,
        'tag' => $tag,
        'paged' => $paged
    ));
}

function NullIsFirstPage(){
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
  return $paged == 1;
}

// If desired, a featured entry can be displayed on the front page with a
// different style. Currently implemented as a category called "features".
function NullFeature(){
  NullQuery(1, array('features'));
  return NullTag(
    'div',
    NullLoop('NullFeaturedEntry', 'empty')."<hr>",
    array('class' => 'row featured')
  );
}
?>
