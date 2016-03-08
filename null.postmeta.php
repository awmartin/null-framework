<?php

// Returns HTML that shows "Posted on YYYY-MM-DD by Author"
function NullPostedOn() {
    if (hasThumbnail()) {
        $class = "post-info-custom style-links";
        }
    else {
        $class = "post-info-custom no-thumbnail style-links";
        }

    return NullTag(
        'div',
        get_plinth_posted_on(),
        array('class' => $class)
        );
}

function NullPostTags($html=false){
    $posttags = get_the_tags();
    if (!$html) {
        return $posttags;
    } else {
        if ($posttags) {
            $tagsString = '';

            foreach($posttags as $tag) {
                $link = get_tag_link($tag->term_id);
                $name = $tag->name;

                $tag = NullTag('li',
                        NullLink($name, $link),
                        array('class' => 'tag')
                        );

                $tagsString = $tagsString.$tag;
            }

            return NullTag('ul', $tagsString, array('class' => 'tags'));
        } else {
            return NullTag('ul', '', array('class' => 'tags'));
        }
    }
}

function NullPostCategories($html=false) {
    if (!$html) {
        return get_categories();
    } else {

    	$categories_list = get_the_category_list( __( ', ', 'plinth' ) );
    	if ( $categories_list ) {
            return NullTag('div', $categories_list, array('class' => 'categories'));
        } else {
            return NullTag('div', '', array('class' => 'categories'));
        }
    }
}

?>
