<?php

function get_null_posted_on() {
  return sprintf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'null' ),
  esc_url( get_permalink() ),
  esc_attr( get_the_time() ),
  esc_attr( get_the_date( 'c' ) ),
  esc_html( get_the_date() ),
  esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
  esc_attr( sprintf( __( 'View all posts by %s', 'null' ), get_the_author() ) ),
  get_the_author()
  );
}

// Returns HTML that shows "Posted on YYYY-MM-DD by Author"
function NullPostedOn() {
  return NullTag(
    'div',
    get_null_posted_on(),
    array('class' => 'post-meta')
  );
}

function NullPostTags(){
  return get_the_tag_list('<ul class="post-tags"><li>','</li><li>','</li></ul>');
}

function format_category($category, $args) {
  $linked = true;
  if (array_key_exists('linked', $args)) {
    $linked = $args['linked'];
  }

  if ($linked) {
    return sprintf(
      '<li><a href="%1$s">%2$s</a></li>',
      esc_url( get_category_link( $category->term_id ) ),
      esc_html( $category->name )
    );
  } else {
    return sprintf(
      '<li>%1$s</li>',
      esc_html( $category->name )
    );
  }
}

function NullPostCategories($args=array()) {
  $html = true;
  $exclude_uncategorized = true;
  $linked = true;
  if (array_key_exists('exclude_uncategorized', $args)) {
    $exclude_uncategorized = $args['exclude_uncategorized'];
  }
  if (array_key_exists('html', $args)) {
    $html = $args['html'];
  }
  if (array_key_exists('linked', $args)) {
    $linked = $args['linked'];
  }

  $categories = get_the_category();
  $cats = array();

  foreach ( $categories as $category ) {
    if ($exclude_uncategorized && $category->name == "Uncategorized") {
      if ($html) {
        $cats[] = '<li>&nbsp;</li>';
      } else {
        $cats[] = ' ';
      }
    } else {
      if ($html) {
        $cats[] = format_category($category, $args);
      } else {
        $cats[] = $category->name;
      }
    }
  }

  if ($html) {
    return NullTag('ul', implode('', $cats), array('class' => 'post-categories'));
  } else {
    return implode(' ', $cats);
  }
}

/*
{
  "@context": "http://schema.org",
  "@type": "LocalBusiness",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Mexico Beach",
    "addressRegion": "FL",
    "streetAddress": "3102 Highway 98"
  },
  "description": "A superb collection of fine gifts and clothing to accent your stay in Mexico Beach.",
  "name": "Beachwalk Beachwear & Giftware",
  "telephone": "850-648-4200"
}
*/


function NullPostSchema() {
  global $schema_info;

  $author_id = get_the_author_meta('ID');
  $author_url = get_the_author_meta('url');
  $author_avatar_url = get_avatar_url($author_id, 512);
  $author_name = get_the_author();
  $author = array(
    '@type' => 'Person',
    'name' => $author_name,
    'url' => $author_url
  );

  $publisher_logo = array(
    '@type' => 'ImageObject',
    'url' => $schema_info['publisher_logo_url'],
    'height' => $schema_info['publisher_logo_height'],
    'width' => $schema_info['publisher_logo_width']
  );
  $publisher = array(
    '@type' => 'Organization',
    'name' => get_bloginfo('name'),
    'logo' => NullJson($publisher_logo)
  );

  $title = get_the_title();

  $thumbnail_id = get_post_thumbnail_id( $post->ID );
  $image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
  $image_src = $image[0];
  $image_width = $image[1];
  $image_height = $image[2];
  if ($image_src) {
    $image = array(
      '@type' => 'ImageObject',
      'url' => $image_src,
      'height' => $image_height,
      'width' => $image_width
    );
  } else {
    $image = false;
  }

  $mainEntity = array(
    '@type' => 'WebSite',
    '@id' => get_bloginfo('url')
  );

  $type = NullIsPage() ? (NullIsAbout() ? 'AboutPage' : 'WebPage') : 'BlogPosting';
  $schema = array(
    '@context' => 'http://schema.org',
    '@type' => $type,
    'dateModified' => get_the_modified_date('c'),
    'datePublished' => get_the_date('c'),
    'name' => $title,
    'headline' => $title,
    'author' => NullJson($author),
    'publisher' => NullJson($publisher),
    'mainEntityOfPage' => NullJson($mainEntity)
  );
  if ($image) {
    $schema['image'] = $image;
  }

  $content = '<script type="application/ld+json">';
  $content .= NullJson($schema);
  $content .= '</script>';

  return $content;
}

function NullJsonKeyValue($key, $value) {
  $quote = "\"";
  $open = "{";
  $colon = ":";

  if (substr(trim($value), 0, 1) === $open) {
    return $quote.$key.$quote.$colon.$value;
  } else if (is_string($value)) {
    return $quote.$key.$quote.$colon.$quote.$value.$quote;
  } else {
    return $quote.$key.$quote.$colon.$value;
  }
}

function NullJson($attr=array()) {
  $quote = "\"";
  $open = "{";
  $close = "}";

  $keyValuePairs = array();
  foreach ($attr as $key => $value) {
    if (is_array($value)) {
      $value = NullJson($value);
    }
    $keyValuePairs[$key] = NullJsonKeyValue($key, $value);
  }

  return $open.join(",", $keyValuePairs).$close;
}
?>
