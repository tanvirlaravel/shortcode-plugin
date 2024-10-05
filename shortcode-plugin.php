<?php 
/**
 * Plugin Name: ShortCode Plugin
 * Description: This is second plugin of the course
 * Author: Md Tanvirul Islam
 * Version: 1.0.0
 * Author URI: www.tanvir.com
 * Plugin URI: https/example.com/hello-world
 */

 /** *****************************************************************
  *                        Basic Shortcode
 *********************************************************************/ 
//  this is short code 
//  [message]

add_shortcode("message", "sp_show_static_message");

function sp_show_static_message() {
    return '<p style="color:red;font-weight:bold;font-size:36px;">Hello i am a simple message</p>';
}

 /** *****************************************************************
  *                        Shortcode with parameters
 *********************************************************************/  
// [message name="tanvir" email="tanvir@gmail.com" ]
add_shortcode("student", "sp_handle_student_data");

function sp_handle_student_data( $attributes ) {
    // var_dump($attributes);
    /*
    Purpose:
    Extracts attributes from a shortcode tag and returns them as an associative array.
    This is crucial for parsing shortcode content and extracting specific parameters or values.
    
    Usage:
    PHP
    $atts = shortcode_atts( array(
        'attribute1' => 'default_value1',
        'attribute2' => 'default_value2',
        // ... more attributes
    ), $atts, $name );
   
    $atts: An associative array containing the extracted attributes.
    array( ... ): An array of default values for each attribute. If a specific attribute is not found in the shortcode tag, its default value will be used.
    $atts: The original array of attributes passed to the shortcode.
    $name: The name of the shortcode being processed.
    */
    $attributes = shortcode_atts( array(
        "name"  => "Default Name",
        "email" => "Default email" 
    ), $attributes, "student");

    // var_dump($attributes);

    return "<h3>Student data: Name: " . $attributes['name'] . "  Email: " . $attributes['email'] . "</h3>";
}

 