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

function NullEntryImageTitleExcerpt() {
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

function NullEntryTitleImageExcerpt() {
    return _NullArticle(
        _NullPostHeader(
            _NullPostTitle(), // entry-title
            _NullPostedOn()   // entry-meta
            ),
            
        _NullPostThumbnail(), // entry-image

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

?>