<?php  session_start();
/*
Plugin Name: BGL Desktop Integration
Plugin URI: https://www.automationlab.com.au
Description: BGL Desktop Integration
Author: Michael Barbecho
Version: 0.1
Author URI: https://www.automationlab.com.au
Author Mail: michael@automationlab.com.au
*/
require_once('autoload.php');






if(bgl360_di_is_local()) {
    echo "<BR> this is local";
    add_action('init', 'bgl360_di_init_method');
} else {
    //echo "<br> This is online ";
}

// register jquery and style on initialization
add_action('init', 'bgl360_di_register_script');
// use the registered jquery and style above
add_action('wp_enqueue_scripts', 'bgl360_di_enqueue_style');
register_activation_hook( __FILE__, 'bgl360_di_install_function');

function bgl360_di_register_script() {
        wp_register_script( 'custom_jquery', plugins_url('assets/js/custom-jquery.js', __FILE__), array('jquery'), '2.5.1' );
    wp_register_style( 'new_style', plugins_url('assets/css/new-style.css', __FILE__), false, '1.0.0', 'all');
    //    wp_register_style( 'bootstrap_min_css', plugins_url('assets/css/bootstrap.min.css', __FILE__ ), false, '1.0.0', 'all');
}
function bgl360_di_enqueue_style(){
    wp_enqueue_script('custom_jquery');
    wp_enqueue_style( 'new_style' );
    //    wp_enqueue_style( 'bootstrap_min_css' );
}
function bgl360_di_init_method() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js');
}
function bgl360_di_install_function()
{
    //bgl desktop upload page
    $post = array(
        'comment_status' => 'closed',
        'ping_status' =>  'closed' ,
        'post_author' => 1,
        'post_date' => date('Y-m-d H:i:s'),
        'post_name' => bgl360_di_page_name_upload,
        'post_status' => 'publish' ,
        'post_title' => 'bgl desktop upload',
        'post_type' => 'page',
        'post_content' => '[bgl360-di-upload]'
    );
    //insert page and save the id
    $newvalue = wp_insert_post( $post, false );
    //save the id in the database
    update_option( 'hclpage', $newvalue );


    //bgl desktop import page
    $post = array(
        'comment_status' => 'closed',
        'ping_status' =>  'closed' ,
        'post_author' => 1,
        'post_date' => date('Y-m-d H:i:s'),
        'post_name' => bgl360_di_page_name_import,
        'post_status' => 'publish' ,
        'post_title' => 'bgl desktop import',
        'post_type' => 'page',
        'post_content' => '[bgl360-di-import]'
    );
    //insert page and save the id
    $newvalue = wp_insert_post( $post, false );
    //save the id in the database
    update_option( 'hclpage', $newvalue );
}

/**
 * @TODO need to get rename the correct folder uploaded to the server so that we can upload different name of .zip files upload/username/renamefolder
 * @TODO need to change permision for bgl_upload so that the script after upload can delete the file after import.
 * @TODO creeat a cronjobs that will delete all the uploaded files and folder in username/date_time_seconds/ except the latest added to avoid delete when current user is still in progress is importing the bgl files
 * Instructions:
 *
 * create page for upload bgl360
 * add this short code: [bgl360-di-upload]
 * create page for import bgl360
 * add this short code: [bgl360-di-import]
 * and configure
 * config/configuration.php
 * for redirect and other stuff.
 * BOOM!
 */


if( is_user_logged_in() ) {

    if ($_SESSION['bgl360_di_is_visited_upload_or_import_page'] == true) {
        $_SESSION['bgl360_di_is_visited_upload_or_import_page'] = false;
        bgl360_di_redirect(site_url() . '/' . bgl360_di_page_name_upload);
        exit;
    }
}




?>





