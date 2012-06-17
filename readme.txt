=== WP HeadJS ===
Contributors: beezeee
Donate link: http://www.brianzeligson.com
Tags: headjs, javascript, wp_enqueue_script
Requires at least: 2.9.1
Tested up to: 3.2.1
Stable tag: tags/0.1

Uses HeadJS to load your enqueued scripts asynchronously, in parallel, executing them in order.

== Description ==

This plugin uses the wp_print_scripts action hook, as opposed to output buffering and regex used by alternative implementations.

The downside of this method is that only scripts loaded via wp_enqueue_script will be affected by the plugin, the upside is better
performance by avoiding output buffering on every page load.

The plugin will preserve any localizations added via wp_localize_script, and uses the first parameter passed to wp_enqueue_script
as the label for the script in the head.js call. For example,

    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
    
would show up as

    head.js({"jquery": "https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"});
    
This allows you to run callbacks when specific scripts are ready, such as

    head.ready('jquery', function() {
        //do something when jquery is loaded
    });
    
For more on HeadJS usage, see http://headjs.com/


== Installation ==

The easiest way is via Plugins->Add New from the left sidebar of your WP Admin, just search for headjs.