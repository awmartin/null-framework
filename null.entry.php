<?php

function NullFeaturedEntry() {
    return _NullArticle(
        _NullPostThumbnail('full'),

        _NullExcerpt(),

        _NullPostHeader(
            _NullPostTitle(),
            _NullPostedOn()
            ),

        _NullClear()
        );
}

/*
    |  IMAGE  |  Title...  |  Excerpt...........  |
*/
function NullEntryImageTitleExcerpt() {
    return _NullArticle(
        _NullPostThumbnail('medium', true),

        _NullPostHeader(
            _NullPostTitle(),
            _NullPostedOn()
            ),

        _NullFirstParagraph(),
        _NullClear()
        );
    }

function NullEntryTitleImageExcerpt() {
    return _NullArticle(
        _NullPostHeader(
            _NullPostTitle(), // entry-title
            _NullPostedOn()   // entry-meta
            ),

        _NullPostThumbnail('medium', true), // entry-image

        _NullContent(),       // entry-content
        _NullClear()
        );
}


function IndexEntry() {
    return _NullArticle(
        _NullPostThumbnail(),

        _NullPostHeader(
            _NullPostTitle(),
            _NullPostedOn()
            ),

        _NullExcerpt(),
        _NullClear()
        );
}

function NullVerticalPostStack() {
    return _NullArticle(
        _NullPostedOn(),

        _NullPostHeader(
            _NullPostTitle()
            ),

        _NullPostThumbnail('large'),

        _NullExcerpt(),

        NullReadMoreLink(),

        _NullClear(),
        array('class' => 'vertical')
        );
}

?>
