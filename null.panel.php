<?php
    
function NullPanel($content, $backgroundImageUrl, $attr=array()) {
    return NullTag(
        'div',
        $content,
        array(
            'class' => 'panel',
            'style' => 'background-image:url('.$backgroundImageUrl.');background-position-y:-70px;'
        ));
}


function NullPostThumbnailPanel() {
    $panel = '';
    if (hasThumbnail()){
        $post_thumbnail_id = get_post_thumbnail_id( $post_id );
        
        // https://codex.wordpress.org/Function_Reference/wp_get_attachment_image_src
        $thumbnail_attr = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
        $url = $thumbnail_attr[0];
        
        $content = NullTag('div',
            '',
            array('class' => 'bg')).
            NullTag('div',
                NullTag('h1', get_the_title()),
                array('class' => 'hero row')
            );
        $panel = NullPanel($content, $url);
    } else {
        $panel = NullTag('div', '', array('class' => 'no-panel'));
    }
    return $panel;
}

function NullHeroPanel($content, $backgroundImageUrl, $options=array()) {
    $dim = true;
    if (array_key_exists('dim', $options)) {
        $dim = $options['dim'];
    }
    
    $hero = '';
    if ($dim) {
        $hero = NullTag('div', '', array('class' => 'bg'));
    }
    
    $hero = $hero.
        NullTag('div',
            $content,
            array('class' => 'hero row')
        );
    
    return NullPanel($hero, $backgroundImageUrl);
}
?>
