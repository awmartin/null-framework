<?php

function NullPostSidebar() {
  $sidebar = NullWidgetArea('Post');
  return NullTag(
    'aside',
    $sidebar
  );
}

function NullPostContent($more=false) {
  $content = "";
  if ($more) {
    $content = getPostContent( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'null' ) );
  } else {
    $content = getPostContent();
  }
  return $content;
}

function getPostContent($more_link_text = null, $stripteaser = false){
  global $more;
  $more = 1;
  // Emulates the_content() without being stupid.
  $content = get_the_content($more_link_text, $stripteaser);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

function NullPostPagination() {
  $attr = array(
    'before' => '<div class="page-links row">' . __( 'Pages:', 'null' ),
    'after' => '</div>',
    'echo' => 0
    );
  return wp_link_pages($attr);
}

function NullReadMoreLink() {
  return NullLink('Read more...', get_permalink());
}

function NullExcerpt() {
  global $more;
  $original_more = $more;
  $more = 0;

  // I think this is supposed to respect the <!--more--> tag and provide excerpts with full HTML.
  $excerpt = get_the_content("");
  $excerpt = trim($excerpt);
  $excerpt = apply_filters('the_content', $excerpt);
  $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
  $more = $original_more;

  return $excerpt;
}

function NullMoreExcerpt() {
  $excerpt = get_the_content("Read More …");
  $excerpt = trim($excerpt);
  $excerpt = apply_filters('the_content', $excerpt);
  $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
  return NullTag('div', $excerpt, array('class' => 'excerpt'));
}

function NullFirstParagraph($asExcerpt=true) {
  $excerpt = NullExcerpt();
  $first_paragraph = getTextBetweenTags($excerpt, 'p');

  if (!$asExcerpt) {
    return $first_paragraph;
  }

  return NullTag('p', $first_paragraph);
}

function getTextBetweenTags($string, $tagname) {
  $pattern = "/<$tagname\s?[^>]*?>([\w\W]*?)<\/$tagname>/";
  preg_match($pattern, $string, $matches);
  return $matches[1];
}

function NullPostContentWithoutExcerpt() {
  $content = NullPostContent();
  $content = str_replace(NullFirstParagraph(), "", $content);

  // Remove that damned paragraph/span combination from the <!--more--> tag.
  $content = preg_replace('/<p><span id="more-([0-9])*"><\/span><\/p>/', "", $content);

  return $content;
}

function NullPostTitle($tag='h1') {
  $title = getPostTitle();
  $permalink = get_permalink();

  $linkAttr = array(
    'href' => $permalink,
    'rel' => 'bookmark'
  );
  $linkToPost = NullTag('a', $title, $linkAttr);

  return NullTag($tag, $linkToPost);
}

// Return the text title for the current single or page.
function getPostTitle() {
  return get_the_title();
}

function hasThumbnail() {
    return function_exists('has_post_thumbnail') && has_post_thumbnail();
}

function NullFeaturedImage($size='thumbnail') {
  if (hasThumbnail()) {
    return NullFlag('img', array(
      'src' => NullPostThumbnailUrl($size),
      'class' => 'featured',
      'alt' => NullPostThumbnailAlt()
    ));
  } else {
    return "";
  }
}

function NullPostThumbnailAlt() {
  $thumbnailId = get_post_thumbnail_id($post->ID);
  return wp_get_attachment($thumbnailId)['alt'];
}

// https://wordpress.org/ideas/topic/functions-to-get-an-attachments-caption-title-alt-description
function wp_get_attachment( $attachment_id ) {
  $attachment = get_post( $attachment_id );
  return array(
    'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
    'caption' => $attachment->post_excerpt,
    'description' => $attachment->post_content,
    // 'href' => get_permalink( $attachment->ID ),
    'src' => $attachment->guid,
    'title' => $attachment->post_title
  );
}

function NullPostThumbnailUrl($size='thumbnail') {
  $thumbnailId = get_post_thumbnail_id($post->ID);
  $thumbnail = wp_get_attachment_image_src($thumbnailId, $size, false);

  if (!$thumbnail[0]) {
    return false;
  } else {
    return $thumbnail[0];
  }
}

function NullPostThumbnail($size='medium', $placeholder=false) {
  if (hasThumbnail()) {
    $permalink = get_permalink();
    $thumbnail = get_the_post_thumbnail(get_the_ID(), $size); // <img />

    $linkAttr = array('href' => $permalink);
    $content = NullTag('a', $thumbnail, $linkAttr);

    $attr = array('class' => 'thumbnail');
    return NullTag('div', $content, $attr);
  } else {
    if ($placeholder) {
      $attr = array('class' => 'thumbnail empty');
      return NullTag('div', '&nbsp;', $attr);
    } else {
      $attr = array('class' => 'thumbnail empty');
      return NullTag('div', '<!--no thumbnail here-->', $attr);
    }
  }
}

function NullPostFormat() {
  if (has_post_format()) {
    return get_post_format();
  } else {
    return 'standard';
  }
}

function NullPostFormatTemplate() {
  $path = getThisThemeFolder() . '/single-' . NullPostFormat() . '.php';
  if (file_exists($path)) :
    include $path;
  else:
    Null404();
  endif;
}

function NullIsPost() {
  return NullPostType() == 'post';
}

function NullIsPage() {
  return NullPostType() == 'page';
}

function NullPostType() {
  global $post;
  return $post->post_type;
}

function NullPostSlug() {
  global $post;
  return $post->post_name;
}

function NullIsAbout() {
  return NullPostSlug() == 'about';
}

function NullPostLink($content, $options=array()) {
  $options['href'] = get_permalink();
  return NullTag('a', $content, $options);
}

function NullComments($args=array()) {
  ob_start();

  if (comments_open()) :
    comments_template();
  endif;

  $comments = ob_get_contents();
  ob_end_clean();

  $before = '';
  $after = '';
  if (array_key_exists('before', $args)) {
    $before = $args['before'];
  }
  if (array_key_exists('after', $args)) {
    $after = $args['after'];
  }
  return $before . $comments . $after;
}
?>
