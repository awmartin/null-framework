<?php

// Returns HTML that shows "Posted on YYYY-MM-DD by Author"
function NullPostedOn() {
  return NullTag(
    'div',
    get_plinth_posted_on(),
    array('class' => 'post-meta')
  );
}

function NullPostTags(){
  return get_the_tag_list('<ul class="post-tags"><li>','</li><li>','</li></ul>');
}

function NullPostCategories() {
  return get_the_category_list();
}
?>
