<?php
// Adds Scripts
function zervise_add_scripts()
{
  // Adds Main CSS
  wp_enqueue_style('yts-main-style', plugin_dir_url(__FILE__) . '/css/style.css', array(), null, 'all');
  // Adds Main JS
  wp_enqueue_script('yts-main-script', plugin_dir_url(__FILE__) . '/js/main.js', array(), null, 'all');

  // Adds Font-awesome Script
  wp_register_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
  wp_enqueue_style('fontawesome');
}

add_action('wp_enqueue_scripts', 'zervise_add_scripts');
