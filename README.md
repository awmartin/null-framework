# Null Wordpress Framework

"Null" is a Wordpress theme framework that takes the HTML out of Wordpress theme authoring. Here 
is a sample `single.php` page:

    <?php
    NullHeader();

    function SingleContent() {
        return _NullArticle(
            _NullPostHeader(
                _NullPostTitle()
                .NullBreadcrumb()
                ),
                
            _NullExcerpt(),
            
            _NullPostThumbnail('full'),

            NullHeaderClear(),

            _NullContentWithoutExcerpt(
                _NullPostedOn()
                ._NullClear()
                .NullComments()
            ),
        
            _NullSidebar()
        );
    }

    NullPrimary('SingleContent');

    NullFooter();
    ?>

Instead of using embedded PHP, inconsistenly named and functioning Wordpress theme functions, 
and HTML, you can use Null functions with a consistent naming scheme, which are named after what 
they display. CSS is standardized to make it easier to use typical layout schemes like grids, 
sidebars, etc.

## Example

For a sample theme using Null and a theme you can start with as a base theme (with CSS), see 
[Spatial Pixel](https://github.com/awmartin/spatialpixel).

## Using Null

Null is designed to be added to an existing theme and migrated carefully. Or, you can start with a 
new theme entirely. Add a folder `null` to your existing theme, then require `null.php` from your
`functions.php` file. E.g.

    require( get_template_directory() . '/null/null.php' );

## Contributing

If you'd like to contribute, please fork the repo and send a pull request with 
a nice commit message. Screenshots are great. Try to fit the naming conventions. :)

## License

MIT License. See LICENSE.txt.

