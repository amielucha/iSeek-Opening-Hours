=== Plugin Name ===
Contributors: amielucha
Donate link: https://amielucha.com/
Tags: opening hours, business
Requires at least: 3.0.1
Tested up to: 3.6.1
Stable tag: 0.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Opening Hours plugin designed to be used in theme files.

== Description ==

Opening Hours plugin designed to be used in theme files.

Adds *Opening Hours* page to the WordPress Settings menu where you can input opening hours for each day of the week.

To output the results in the theme files use `iseek_opening_hours()` function.

`iseek_is_open()` function is still in alpha. It outputs whether the store is open at the moment basing on the currently captured server hour.

Note: `iseek_is_open()` is not compatible with caching, use it with caution.

== Installation ==

1. Install the plugin
1. Configure Settings -> Opening Hours
1. Place `iseek_opening_hours()` in your theme files


== Changelog ==

= 0.1.0 =
* Initial release
