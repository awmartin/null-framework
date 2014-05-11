<?php
function NullPostedOn() {
    echo _NullPostedOn();
    }

function _NullPostedOn() {
    if (hasThumbnail()) {
        $class = "post-info-custom style-links";
        }
    else {
        $class = "post-info-custom no-thumbnail style-links";
        }
    
    $postedString = get_plinth_posted_on();
    if ($attr == null) {
        $attr = array('class' => $class);
        }
    
    // $posttags = NullPostTags(true);
    // if ($posttags) {
    //     $postedString = $postedString.'<ul class="tags">';
    //     foreach($posttags as $tag) {
    //         $link = get_tag_link($tag->term_id);
    //         $name = $tag->name;
    //         $postedString = $postedString.'<li class="tag"><a href="'.$link.'">'.$name.'</a></li>';
    //     }
    // $postedString = $postedString.'</ul>';
    // }
    
    return NullTag('div', $postedString, $attr);
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