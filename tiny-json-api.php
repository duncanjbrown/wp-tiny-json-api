<?php
/*
Plugin Name: Tiny JSON API
Version: 1
Description: Accept requests for JSON 
Author: Duncan Brown
Author URI: https://1pass.me
*/

include( 'vendor/parse-accept.php' );
include( 'lib/serve-json.php' );

register_activation_hook( __FILE__, function() {
    flush_rewrite_rules();
} );
