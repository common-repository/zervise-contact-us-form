<?php
/*
Plugin Name: Zervise Contact Us Form
Plugin URI: https://wordpress.org/plugins/search/zervise-contact-us
Description: Use Zervise Contact Us Form to give your users the easiest way to connect with you for support.
Version: 1.0.0
Author: Zervise
Author URI: https://zervise.com
*/


// Exit if accessed directly
if(!defined('ABSPATH')){
  exit;
}

// Loads Scripts
require_once(plugin_dir_path(__FILE__).'/includes/zervise-contact-us-scripts.php');

// Loads Class
require_once(plugin_dir_path(__FILE__).'/includes/zervise-contact-us-class.php');

// Registers Widget
function register_zervise_contact_us(){
  register_widget('Zervise_Contact_Us_Widget');
}

// Hook in function
add_action('widgets_init', 'register_zervise_contact_us');