<?php

function NullArchiveType() {
  if (is_category()) :
    return 'category';
  elseif (is_tag()) :
    return 'tag';
  elseif (is_author()) :
    return 'author';
  elseif (is_day()) :
    return 'day';
  elseif (is_month()) :
    return 'month';
  elseif (is_year()) :
    return 'year';
  else :
    return 'default';
  endif;
}

function NullArchiveTitle() {
  return NullTag('h1', getArchiveTitle());
}

function getArchiveTitle() {
  if ( is_category() ) :
    return single_cat_title( '', false );

  elseif ( is_tag() ) :
    return single_tag_title( '', false );

  elseif ( is_author() ) :
    return NullAuthorFullName();

  elseif ( is_day() ) :
    return sprintf( __( 'Daily Archives: %s', 'null' ), get_the_date() );

  elseif ( is_month() ) :
    return sprintf( __( 'Monthly Archives: %s', 'null' ), get_the_date( 'F Y' ) );

  elseif ( is_year() ) :
    return sprintf( __( 'Yearly Archives: %s', 'null' ), get_the_date( 'Y' ) );

  elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
    return __( 'Asides', 'null' );


  // elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
  //   return __( 'Images', 'null');
  //
  // elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
  //   return __( 'Videos', 'null' );
  //
  // elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
  //   return __( 'Quotes', 'null' );
  //
  // elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
  //   return __( 'Links', 'null' );

  else :
    return __( 'Archives', 'null' );

  endif;
}

function NullArchiveDescription() {
  if ( is_category() ) :
    return NullCategoryDescription();

  elseif ( is_tag() ) :
    return NullTagDescription();

  elseif ( is_author() ) :
    return NullAuthorBio();

  else:
    return "";

  endif;
}

function NullCategoryDescription() {
  if ( is_category() ) :
    $category_description = category_description();
    if ( !empty( $category_description ) ) :
      return apply_filters( 'category_archive_meta', $category_description );
    endif;
  endif;
  return "";
}


function NullTagDescription() {
  if ( is_tag() ) :
    $tag_description = tag_description();
    if ( !empty( $tag_description ) ) :
      return apply_filters( 'tag_archive_meta', $tag_description );
    endif;
  endif;
  return "";
}

function NullAuthorFullName() {
  global $wp_query;
  $author_obj = $wp_query->get_queried_object();
  return $author_obj->first_name . ' ' . $author_obj->last_name;
}

function NullAuthorBio($id=null) {
    if ($id != null) {
        $user = get_user_by('login', $id);
        if ($user) {
            return $user->description;
        }
        return "hello";
        // return $author_obj;
        // return $author_obj->get('description');
    } else {
        global $wp_query;
        $author_obj = $wp_query->get_queried_object();
        return $author_obj->description;
    }
}
?>
