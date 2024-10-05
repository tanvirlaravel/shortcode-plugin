<?php 
/**
 * Plugin Name: ShortCode Plugin
 * Description: This is second plugin of the course
 * Author: Md Tanvirul Islam
 * Version: 1.0.0
 * Author URI: www.tanvir.com
 * Plugin URI: https/example.com/hello-world
 */

//  this is short code 
//  [message]

add_shortcode("message", "sp_show_static_message");

function sp_show_static_message() {
    return '<p style="color:red;font-weight:bold;font-size:36px;">Hello i am a simple message</p>';
}