<?php

function NullFeaturedEntry() {
    return NullArticle(
        NullPostThumbnail('full'),

        NullExcerpt(),

        NullPostHeader(
            NullPostTitle(true),
            NullPostedOn()
            ),

        NullClear()
        );
}

/*
    |  IMAGE  |  Title...  |  Excerpt...........  |
*/
function NullEntryImageTitleExcerpt() {
    return NullArticle(
        NullPostThumbnail('medium', true),

        NullPostHeader(
            NullPostCategories(true),
            NullPostTitle(true),
            NullPostedOn(),
            NullPostTags(true)
            ),

        NullFirstParagraph(),
        NullClear()
        );
    }

function NullEntryTitleImageExcerpt() {
    return NullArticle(
        NullPostHeader(
            NullPostTitle(true), // entry-title
            NullPostedOn()   // entry-meta
            ),

        NullPostThumbnail('medium', true), // entry-image

        NullContent(),       // entry-content
        NullClear()
        );
}


function IndexEntry() {
    return NullArticle(
        NullPostThumbnail(),

        NullPostHeader(
            NullPostTitle(true),
            NullPostedOn()
            ),

        NullExcerpt(),
        NullClear()
        );
}

function NullVerticalPostStack() {
    return NullArticle(
        NullPostedOn(),

        NullPostHeader(
            NullPostTitle(true)
            ),

        NullPostThumbnail('large'),

        NullExcerpt(),

        NullReadMoreLink(),

        NullClear(),
        array('class' => 'vertical')
        );
}

?>
