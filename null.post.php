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
    $content = get_post_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'plinth' ) );
  } else {
    $content = get_post_content();
  }
  return $content;
}

function get_post_content($more_link_text = null, $stripteaser = false){
    // Emulates the_content() without being stupid.
    $content = get_the_content($more_link_text, $stripteaser);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}

function NullPostPagination() {
  $attr = array(
    'before' => '<div class="page-links row">' . __( 'Pages:', 'plinth' ),
    'after' => '</div>',
    'echo' => 0
    );
  return wp_link_pages($attr);
}

function NullEditPostLink() {
  return return_edit_post_link(
    __( 'Edit', 'plinth' ),
    '<span class="edit-link">',
    '</span>'
  );
}

function return_edit_post_link( $link = null, $before = '', $after = '', $id = 0 ) {
  if ( !$post = get_post( $id ) ) return;

  if ( !$url = get_edit_post_link( $post->ID ) ) return;

  if ( null === $link ) {
    $link = __('Edit This');
  }

  $post_type_obj = get_post_type_object( $post->post_type );
  $link = '<a class="post-edit-link" href="' . $url . '" title="' . esc_attr( $post_type_obj->labels->edit_item ) . '">' . $link . '</a>';
  return $before . apply_filters( 'edit_post_link', $link, $post->ID ) . $after;
}

function is_post(){
  return 'post' == get_post_type();
}

function sep(){
  return NullTag('span', ' | ', array('class' => 'sep'));
}

function NullReadMoreLink() {
  return NullTag('p', NullLink('Read more...', get_permalink()), array('class' => 'read-more'));
}

function NullExcerpt($attr=null) {
  global $more;
  $original_more = $more;
  $more = 0;

  $excerpt = get_the_content("");
  $excerpt = trim($excerpt);
  $excerpt = apply_filters('the_content', $excerpt);
  $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
  $more = $original_more;

  return $excerpt;
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

function NullPostTitle($entry=false) {
  $title = get_the_title();
  $permalink = get_permalink();
  $linkTitleAttr = esc_attr(
    sprintf( __( 'Permalink to %s', 'plinth' ), the_title_attribute( 'echo=0' ))
  );

  $linkAttr = array(
    'title' => $linkTitleAttr,
    'href' => $permalink,
    'rel' => 'bookmark'
  );
  $linkToPost = NullTag('a', $title, $linkAttr);

  $tag = "h1";
  if ($entry) {
    $tag = "h3";
  }
  $headerTitle = NullTag($tag, $linkToPost, array('class' => 'post-title'));

  return $headerTitle;
}

function hasThumbnail() {
    return function_exists('has_post_thumbnail') && has_post_thumbnail();
}

function NullFeaturedImage($size='thumbnail') {
  if (hasThumbnail()) {
    return NullFlag('img', array(
      'src' => NullPostThumbnailUrl($size),
      'class' => 'featured'
    ));
  } else {
    return "";
  }
}

function NullPostThumbnailUrl($size='thumbnail') {
  $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID, $size));

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
?>
