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

 /** *****************************************************************
  *                        Shortcode with db operation
 *********************************************************************/ 
add_shortcode("list-posts", "sp_handle_list_posts_wp_query_class");

function sp_handle_list_posts(){
    /*
    The $wpdb global variable in WordPress is a crucial object that provides access to the database. It encapsulates methods for interacting with the WordPress database, making it easier to perform various database operations.

    Key Functions and Properties:
    $wpdb->prepare(): This function prepares SQL statements, preventing SQL injection vulnerabilities by properly escaping and formatting data.
    $wpdb->query(): Executes a prepared SQL statement and returns the number of rows affected or the result set.
    $wpdb->get_var(): Retrieves a single value from the database.
    $wpdb->get_row(): Fetches a single row from the database as an object.
    $wpdb->get_results(): Retrieves multiple rows from the database as an array of objects.
    $wpdb->insert(): Inserts a new row into the database.
    $wpdb->update(): Updates an existing row in the database.
    $wpdb->delete(): Deletes a row from the database.
    $wpdb->show_errors(): Enables or disables error display.
    */
    global $wpdb;

    $table_prefix = $wpdb->prefix; // wp_
    $table_name = $table_prefix . "posts"; // wp_posts

    // Get posts where post type = post and post status = published
    $posts = $wpdb->get_results(
        "SELECT post_title FROM {$table_name} WHERE post_type='post' AND post_status='publish' "
    );

   if( count($posts) > 0 ){

    $outputHtml = "<ul>";

    foreach( $posts as $post ){
        $outputHtml .= "<li>" . $post->post_title . "</li>";
    }

    $outputHtml .= "</ul>";

    return $outputHtml;
   }

   return "<h3>No post found</h3>";
}

function sp_handle_list_posts_wp_query_class($attributes){

    $attributes = shortcode_atts( array(
        "number"    => 5,
    ), $attributes, "list-posts");

    /*
    Purpose:    The WP_Query class is a powerful tool for querying and retrieving posts, pages, custom post types, and other WordPress data from the database.
        It provides a flexible and efficient way to customize and filter your content based on various criteria, such as post type, author, date, category, tags, and more.
    
    Key Properties:
        $query_vars: An array of query variables that define the query parameters.
        $posts: An array of WP_Post objects representing the retrieved posts.
        $post: The current post object (if applicable).
        $have_posts: A boolean indicating whether there are more posts to retrieve.
        $found_posts: The total number of posts found in the query.
    */

    $query = new WP_Query( array(
        "posts_per_page"    => $attributes['number'],
        "post_status"       => 'publish'
    ) );

    if( $query->have_posts() ){

        $outputHtml = "<ul>";

        while( $query->have_posts() ) {
            $query->the_post();

            $outputHtml .= '<li class="my-class"><a href="' . get_the_permalink(  ) . '"> ' . get_the_title() . ' </a></li>';
        }

        $outputHtml .="</ul>";

        return $outputHtml;

    }

    return "<h3>No post found</h3>";


}