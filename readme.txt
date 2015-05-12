=== Author RSS Feed ===
Contributors: danielpataki
Tags: rss, feed, authors, widget
Requires at least: 3.5.0
Tested up to: 4.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A widget which lets you show different RSS feeds for your authors on their author pages and posts.

== Description ==

The Author RSS Widget is very similar to the default RSS widget but offers author-specific RSS feeds. This means that you can display the RSS feed of your authors on their author archive page or posts that they've written.

= Usage =

The plugin gives you 5 options to tweak. The "Title" and Items To Show" options should be pretty self-explanatory. The former controls the widget's title, the later controls the number of items displayed from the feed.

The "Field Name" option is needed because there is no built-in way to add an author's feed URL to WordPress. Author RSS Feed needs to know how you saved this data to the database. Add user meta field name you are using here.

There are a number of ways to add additional fields to the user edit screen, I recommend [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/). Once you've added a field to the User Form make sure to use the generated "Field Name" here in Author RSS Field.

The "Default Field URL" setting can be used as a fallback. If an author's feed can not be found or the widget is displayed on any other page than the author archive or single post page, this URL will be used. It may be left empty, in which case the widget will not be displayed at all. This is useful if you either want to show the author's RSS feed, or nothing at all.

The "Show Feed On" setting controls when the author's RSS field overwrites the default RSS field. This allows you to show the author's feed on his/her author archive, but not on single post pages.

= Thanks =

* [Font Awesome](http://fortawesome.github.io/Font-Awesome/) for the plugin icon


== Installation ==

= Automatic Installation =

Installing this plugin automatically is the easiest option. You can install the plugin automatically by going to the plugins section in WordPress and clicking Add New. Type Author RSS Feed" in the search bar and install the plugin by clicking the Install Now button.

= Manual Installation =

To manually install the plugin you'll need to download the plugin to your computer and upload it to your server via FTP or another method. The plugin needs to be extracted in the `wp-content/plugins` folder. Once done you should be able to activate it as usual.

If you are having trouble, take a look at the [Managing Plugins](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation) section in the WordPress Codex, it has more information on this topic.

== Screenshots ==

1. The widget's options
2. The widget displayed in the the Twenty Fifteen Theme
3. The widget displayed in the the Twenty Fourteen Theme
4. The widget displayed in the the No Nonsense Theme

== Changelog ==

= 1.0.2 (2015-05-12) =
* Added widget_title filter to the widget title

= 1.0.1 (2015-05-05) =

* Ironed out a kink with a PHP notice
* Made sure default feed can be left blank
* Made sure show on fields can be saved properly

= 1.0.0 =

* Initial Release.
