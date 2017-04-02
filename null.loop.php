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

function getAvailableContent($options=array()) {
  // Some basics about the post.
  $postTitle = NullPostTitle(true);
  $categories = NullPostCategories();
  $excerpt = NullFirstParagraph();


  $featuredImage = '';
  $linkedFeaturedImage = '';
  if (hasThumbnail()) :
    $featuredImageSize = 'thumbnail';
    if (array_key_exists('featuredsize', $options)) {
      $featuredImageSize = $options['featuredsize'];
    }
    $featured = NullFeaturedImage($featuredImageSize);
    $featuredImage = NullTag('div', $featured, array('class' => 'featured'));
    $linkedFeaturedImage = NullTag('div', NullPostLink($featuredImage), array('class' => 'featured'));
  endif;


  $availableContent = array(
    'title' => $postTitle,
    'thumbnail' => NullPostThumbnail('thumbnail', true),
    'featured' => $featuredImage,
    'linkedfeatured' => $linkedFeaturedImage,
    'categories' => $categories,
    'unlinkedcategories' => NullPostCategories(array('linked' => false)),
    'tags' => NullPostTags(),
    'postedon' => NullPostedOn(),
    'excerpt' => $excerpt,
    'linkedexcerpt' => NullPostLink($excerpt),
    'format' => NullPostFormat(),
    'categories+title' => '<div>'.$categories.$postTitle.'</div>'
  );

  $availableContent['titleplus'] =
    $availableContent['categories']
    .$availableContent['title']
    .$availableContent['postedon']
    .$availableContent['tags'];

  return $availableContent;
}


function EntryLayout($options=array()) {
  global $availableColumnWidths;
  global $widths;

  $availableContent = getAvailableContent($options);


  $numColumns = 1;
  if (array_key_exists('num_columns', $options)) :
    $numColumns = $options['num_columns'];
  endif;


  // Retrieves the layout for the given format.
  // 'format' => 'orientation-field1-field2-field3...''
  $format = $availableContent['format'];
  $orientation = 'unspecified';

  $columnWidth = $availableColumnWidths[$numColumns];
  $columnWidthClass = $columnWidth." columns";

  if (is_sticky() && array_key_exists('stickies', $options)) {
    $columnWidthClass = "sticky twelve columns";
    $format = 'sticky';
  }

  $layout = 'title'; // generic title to start
  if (array_key_exists($format, $options)) :
    $layout = $options[$format];
  elseif (array_key_exists('standard', $options)) :
    $layout = $options['standard'];
  endif;
  $layoutParts = split('-', $layout);

  $attr = array('class' => 'entry ' . $format);

  if ($format == 'standard') {
    $orientation = $layoutParts[0];
    $partWidth = $availableColumnWidths[count($layoutParts) - 2];

    $content = '';
    for ($i = 1, $len = count($layoutParts); $i < $len; $i++) {

      // Don't remember what this was for...
      // if (array_key_exists('entry-column-widths', $options)) {
      //   $partWidth = $widths[$options['entry-column-widths'][$i - 2]];
      // }

      if ($orientation == 'horizontal') {
        $content .= '<div class="'.$partWidth.' columns">';
      }

      // Get the piece of content out of the available pre-fetched content.
      $itemKey = $layoutParts[$i];
      if (array_key_exists($itemKey, $availableContent)) {
        $item = $availableContent[$itemKey];
        $content .= trim($item);
      }

      if ($orientation == 'horizontal') {
        $content .= '</div>';
      }
    }

  } else {

    $content = '';
    for ($i = 0, $len = count($layoutParts); $i < $len; $i++) {
      $itemKey = $layoutParts[$i];
      if (array_key_exists($itemKey, $availableContent)) {
        $item = $availableContent[$itemKey];
        $content .= trim($item);
      }
    }

    $attr['data-excerpt'] = NullFirstParagraph(false);
  }

  if ($orientation == 'vertical' || $orientation == 'unspecified') {
    // Apply the width of the entire entry here if we're using a vertical entry layout.
    // Horizontal layouts tend to be arbitrarily wide.
    $attr['class'] .= " ".$columnWidthClass;
  }

  $schema = NullPostSchema();
  return NullTag('article', $content.$schema, $attr);
} // End EntryLayout



// Passing in a function as an argument.
// http://stackoverflow.com/questions/627775/php-pass-function-as-param-then-call-the-function
function NullLoop($options=array()) {
  ob_start();

  if (have_posts()):
    $currentPost = 0;
    $numColumns = 1;
    if (array_key_exists('num_columns', $options)) :
      $numColumns = $options['num_columns'];
    endif;

    $closed = false;
    while (have_posts()):
      the_post();

      $format = NullPostFormat();

      // Support for sticky posts.
      if (is_sticky() && array_key_exists('stickies', $options)) {
        $stickyOptions = $options;
        $stickyOptions['featuredsize'] = 'large';

        echo StartRow();
        echo EntryLayout($stickyOptions);
        echo EndRow();

        // Skip to the next post.
        the_post();

        // But think of it as the first in the grid layout.
        $currentPost = 0;
      }

      if ($currentPost % $numColumns == 0) {
        $closed = false;
        echo StartRow();
      }

      echo EntryLayout($options);

      if (($currentPost + 1) % $numColumns == 0) {
        $closed = true;
        echo EndRow();
      }

      $currentPost++;

    endwhile; // end of the loop.

    if (!$closed):
      echo EndRow();
    endif;
  else:
    echo '';
    // get_template_part( 'no-results', $noResultsTemplate );
  endif;

  $loopContent = ob_get_contents();
  ob_end_clean();

  return $loopContent;
}

function NullPagination() {
  return NullTag('nav',
    NullTag('div', get_next_posts_link( 'Older posts' ), array('class' => 'next older'))
    . NullTag('div', get_previous_posts_link( 'Newer posts' ), array('class' => 'previous newer'))
    , array('class' => 'pagination'));
}

?>
