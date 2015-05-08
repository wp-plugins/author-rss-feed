<?php
/*
Plugin Name:       Author RSS Feed
Description:       A widget which lets you show different RSS feeds for your authors on their author pages and posts.
Version:           1.0.1
Author:            Daniel Pataki
Author URI:        http://danielpataki.com/
License:           GPLv2 or later
*/


include "class-author-rss-feed-widget.php";

add_action('plugins_loaded', 'arf_load_textdomain');

/**
 * Load Text Domain
 *
 * Loads the textdomain for translations
 *
 * @author Daniel Pataki
 * @since 1.0.0
 *
 */
function arf_load_textdomain() {
	load_plugin_textdomain( 'author-rss-feed', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
}


add_action( 'widgets_init', 'arf_widget_init' );
/**
 * Widget Initializer
 *
 * This function registers the top author widget with WordPress
 * The Author_RSS_Feed_Widget class must be included beforehand of course
 *
 * @author Daniel Pataki
 * @since 1.0.0
 *
 */
function arf_widget_init() {
	register_widget( 'Author_RSS_Feed_Widget' );
}


add_action( 'admin_enqueue_scripts', 'arf_admin_enqueue' );
/**
 * Backend Assets
 *
 * This function takes care of enqueueing all the assets we need. Right
 * now this consists of the CSS and JS needed to handle the help text in
 * the widget form.
 *
 * @author Daniel Pataki
 * @since 1.0.0
 *
 */
function arf_admin_enqueue($hook) {
    if ( 'widgets.php' != $hook ) {
        return;
    }

	wp_enqueue_script( 'author-rss-feed', plugin_dir_url( __FILE__ ) . '/js/scripts.js', array('jquery'), '1.0.0', true );

	wp_enqueue_style( 'author-rss-feed', plugin_dir_url( __FILE__ ) . '/css/styles.css' );

}
