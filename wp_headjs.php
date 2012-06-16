<?php
/**
Plugin Name: WP HeadJS
Plugin URI: http://github.com/beezee/wp_headjs
Description: Load all enqueued scripts asynchronously in parallel, and execute in order using <a href="http://headjs.com">HeadJS</a>.
Version: 0.1
Author: Brian Zeligson
Author URI: http://www.brianzeligson.com
*/

if (!class_exists('wpHeadJS'))
{
    class wpHeadJS
    {
        public function __construct()
        {
            $this->add_actions();
        }
        
        public function add_actions()
        {
            add_action('wp_print_scripts', array($this, 'headjs_enqueue'));
        }
        
        public function headjs_enqueue()
        {
            global $wp_scripts;
            $in_queue = $wp_scripts->queue;     
            if (is_admin() or is_feed() or defined('XMLRPC_REQUEST') or empty($in_queue)) return;  
            $scripts = array();
            foreach($in_queue as $script)
            {
                if (is_array($wp_scripts->registered[$script]->extra) and
                    isset($wp_scripts->registered[$script]->extra['data']))
                            echo '<script type="text/javascript">'.$wp_scripts->registered[$script]->extra['data'].'</script>';
                $src = $wp_scripts->registered[$script]->src;
                $src = ( (preg_match('/^(http|https)\:\/\//', $src)) ? '' : get_bloginfo('url') ) . $src;
                $scripts[] = '{"' . $script . '":"' . $src . '"}';
            }
            if (!property_exists($wp_scripts, 'headjs_enqueued'))
            {
                echo "<script type=\"text/javascript\" src=\"".get_bloginfo('wpurl') . "/wp-content/plugins/".basename(dirname(__FILE__))."/head.min.js\"></script>\n";
                $wp_scripts->headjs_enqueued = true;
            }
            echo "<script type=\"text/javascript\">head.js(\n". implode(",\n", $scripts). "\n);</script>\n";
            $wp_scripts->queue = array();
        }
        
    }
    
    $headjs = new wpHeadJS();
}