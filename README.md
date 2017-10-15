# Null Wordpress Framework

"Null" is a Wordpress theme framework that takes the HTML out of Wordpress theme authoring. Here
is a sample `single.php` page:

    <?php
    echo NullHeader();

    echo NullPostTitle()
      .NullBreadcrumb();
      .NullPostThumbnail('large');

    echo NullContentSidebarLayout(
      NullPostContent(),
      NullWidgetArea('Post')
    );

    echo NullFooter();
    ?>

Thats it. Instead of using embedded PHP and complicated, inconsistently named Wordpress functions, you
can use Null functions with a consistent naming and standardized HTML and CSS to get started,
then work from there.

The resulting HTML is intended to be very clean and structured for
[Dave Gamache's](https://github.com/dhg) [Skeleton](http://getskeleton.com) boilerplate CSS
framework, to get nice responsive layouts.


## Example

An example site laid out with Null is my site [Spatial Pixel](http://spatialpixel.com).


## Using Null

Clone this repository into a folder `null` to your existing theme, then require `null.php`
in your `functions.php` file. E.g.

    require( get_template_directory() . '/null/null.php' );

Or download it from GitHub as a zip.


## Contributing

If you'd like to contribute, please fork the repo and send a pull request with
a nice commit message. Screenshots are great. Try to fit the naming conventions. :)


## License

MIT License. See LICENSE.txt.
