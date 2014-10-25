# Groot Theme
[Forked from Roots Starter Theme](http://roots.io/)

A Wordpress template using Roots as a starter point , leveraging gulp for asset management and twig for templating




### Additional features

Install the [Soil](https://github.com/roots/soil) plugin to enable additional features:

* Root relative URLs
* Nice search (`/search/query/`)
* Cleaner output of `wp_head` and enqueued assets markup

## Installation

Clone the git repo - `git clone git://github.com/shantanugautam/wp-gulp-theme.git ` and then rename the directory to the name of your theme or website.

If you don't use [Bedrock](https://github.com/roots/bedrock), you'll need to add the following to your `wp-config.php` on your development installation:

```php
define('WP_ENV', 'development');
```

## Theme activation

Reference the [theme activation](http://roots.io/roots-101/#theme-activation) documentation to understand everything that happens once you activate Roots.

## Configuration

Edit `lib/config.php` to enable or disable theme features and to define a Google Analytics ID.

Edit `lib/init.php` to setup navigation menus, post thumbnail sizes, post formats, and sidebars.

Edit `lib/admin.php` to setup custom theming of the wordpress admin.

## Theme development

Groot uses [gulp](http://gulpjs.com/) for compiling SCSS to CSS, checking for JS errors, live reloading, concatenating and minifying files, versioning assets, and generating lean Modernizr builds.


