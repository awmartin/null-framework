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
  $postTitle = NullPostTitle();
  $categories = NullPostCategories(array('ul' => false));
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

  $wpexcerpt = get_the_excerpt();
  $wpexcerpt = apply_filters('the_excerpt', $wpexcerpt);
  $wpexcerpt = str_replace(']]>', ']]&gt;', $wpexcerpt);

  // TODO Compute post available content on demand.
  $availableContent = array(
    'title' => NullPostTitle('h3'),
    'titleh' => NullPostTitle('h1'),
    'titlehh' => NullPostTitle('h2'),
    'titlehhh' => NullPostTitle('h3'),
    'thumbnail' => NullPostThumbnail('thumbnail', true),
    'featured' => $featuredImage,
    'linkedfeatured' => $linkedFeaturedImage,
    'categories' => $categories,
    'unlinkedcategories' => NullPostCategories(array('linked' => false)),
    'tags' => NullPostTags(),
    'postedon' => NullPostedOn(),
    'date' => NullPostedOn(),
    'postmeta' => NullPostMeta(),
    'excerpt' => $excerpt,
    'wpexcerpt' => $wpexcerpt,
    'moreexcerpt' => NullMoreExcerpt(),
    'linkedexcerpt' => NullPostLink($excerpt),
    'format' => NullPostFormat(),
    'content' => NullTag('div', NullPostContent(), array('class' => 'content')),
    'nbsp' => '&nbsp;',
    'br' => '<br>',
    'ellipsis' => '…',
    'dot' => '&middot;'
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

  $format = $availableContent['format'];

  $columnWidth = $availableColumnWidths[$numColumns];
  $columnWidthClass = $columnWidth." columns";

  if (is_sticky() && array_key_exists('stickies', $options) && $options['stickies']) {
    $columnWidthClass = "sticky twelve columns";
    $format = 'sticky';
  }

  $layoutStr = 'title'; // generic title to start
  if (array_key_exists($format, $options)) :
    $layoutStr = $options[$format];
  endif;

  $mode = 'entries';
  if (array_key_exists('mode', $options)) {
    $mode = $options['mode'];
  }
  // Parse the layout string and convert to HTML.
  $layoutEngine = new Layout($layoutStr, $mode);
  $content = $layoutEngine->toHtml();

  // Take all the fields and convert them to known values.
  foreach ($availableContent as $key => $value) {
    $templateKey = "__" . strtoupper($key) . "__";
    $content = str_replace($templateKey, $value, $content);
  }

  // Prepare the HTML class for the resulting <article> element.
  $attr = array(
    'class'        => 'entry ' . $format . ' ' . $columnWidthClass,
    // 'data-excerpt' => NullFirstParagraph(false),
    );

  $schema = NullPostSchema();
  return NullTag('article', $content.$schema, $attr);
} // End EntryLayout


// Passing in a function as an argument.
// http://stackoverflow.com/questions/627775/php-pass-function-as-param-then-call-the-function
function NullLoop($options=array()) {
  $mode = 'entries';
  if (array_key_exists('mode', $options)) {
    $mode = $options['mode'];
  }

  ob_start();

  if ( have_posts() ):
    $currentPost = 0;
    $numColumns = 1;

    if (array_key_exists('num_columns', $options)) :
      $numColumns = $options['num_columns'];
    endif;

    $closed = false;
    while ( have_posts() ):
      the_post();

      if ( get_post_status() == 'private' ) { continue; }

      $format = NullPostFormat();

      // Support for sticky posts.
      $show_stickies = true;
      if ( is_sticky() && array_key_exists('stickies', $options) && !$options['stickies'] ) {
        $show_stickies = false;
      }
      if ( $show_stickies ) {
        $stickyOptions = $options;
        $stickyOptions['featuredsize'] = 'large';

        echo StartRow();
        echo EntryLayout($stickyOptions);
        echo EndRow();

        // Skip to the next post.
        the_post();

        // But think of it as the first in the grid layout.
        $currentPost = 0;
      } else if ( is_sticky() && !$show_stickies ) {
        continue;
      }

      if ($currentPost % $numColumns == 0) {
        $closed = false;
        if ($mode == 'table') {
          echo NullTagOpen('tr');
        } else {
          echo StartRow();
        }
      }

      echo EntryLayout($options);

      if (($currentPost + 1) % $numColumns == 0) {
        $closed = true;
        if ($mode == 'table') {
          echo NullTagClose('tr');
        } else {
          echo EndRow();
        }
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

  $loopclass = '';
  if (array_key_exists('class', $options)) {
    $loopclass = $options['class'];
  }
  return NullTag('div', $loopContent, array('class' => $loopclass));
}

function NullPagination() {
  return NullTag('nav',
    NullTag('div', get_next_posts_link( 'Older posts' ), array('class' => 'next older'))
    . NullTag('div', get_previous_posts_link( 'Newer posts' ), array('class' => 'previous newer'))
    , array('class' => 'pagination'));
}

?>
