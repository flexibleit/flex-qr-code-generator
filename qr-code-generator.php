<?php
/**
 * Plugin Name: Flex QR Code Generator
 * Description: A simple wordpress plugin to generate and manage QR codes in WordPress.
 * Plugin URI:  https://github.com/flexibleit/flex-qr-code-generator
 * Author:      Ajit Das
 * Author URI:  https://flexibleit.net
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version:     1.1.1
 * Text Domain: flex-qr-code-generator
 *
 * @package flex-qr-code-generator
 */
if (!defined('FLEXQR_CODE_GENERATOR_PATH')) {
  define('FLEXQR_CODE_GENERATOR_PATH', plugin_dir_path(__FILE__));
}
if (!defined('FLEXQR_CODE_GENERATOR_URI')) {
  define('FLEXQR_CODE_GENERATOR_URI', plugin_dir_url(__FILE__));
}
// Register a function to be executed when the plugin is activated
register_activation_hook( __FILE__, 'flexqr_code_generator_activate' );
if (!function_exists('flexqr_code_generator_activate')) {
  function flexqr_code_generator_activate() {
    // Code to run when plugin is activated
  }
}

// Register a function to be executed when the plugin is deactivated
register_deactivation_hook( __FILE__, 'flexqr_code_generator_deactivate' );
if (!function_exists('flexqr_code_generator_deactivate')) {
function flexqr_code_generator_deactivate() {
  // Code to run when plugin is deactivated
}
}

// Adding custom css and js for styling in the WordPress admin area
if (!function_exists('flexqr_code_generator_scripts')) {
function flexqr_code_generator_scripts() {
  wp_enqueue_style( 'flexqr-code-generator-style', FLEXQR_CODE_GENERATOR_URI . 'flexqr-code-generator.css' );
  wp_enqueue_script( 'flexqr-code-generator-script', FLEXQR_CODE_GENERATOR_URI . 'flexqr-code-generator.js', array( 'jquery' ) );
}
}
// Add an action hook to add a custom menu item in the WordPress admin area
add_action( 'admin_menu', 'flexqr_code_generator_menu' );
if (!function_exists('flexqr_code_generator_menu')){
  function flexqr_code_generator_menu() {
    $page = add_options_page( 'QR Code Generator Options', 'QR Code Generator', 'manage_options', 'flexqr-code-generator', 'flexqr_code_generator_options' );
    add_action( "admin_print_styles-{$page}", 'flexqr_code_generator_scripts' );
  }
}

if (!function_exists('flexqr_activate_code_generator_plugin')){
function flexqr_activate_code_generator_plugin() {
   global $wpdb;
 
   $table_name = $wpdb->prefix . 'qr_codes';
 
   // Check if the table already exists
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
     // Table doesn't exist, so create it
     $charset_collate = $wpdb->get_charset_collate();
     $sql = "CREATE TABLE $table_name (
       id mediumint(9) NOT NULL AUTO_INCREMENT,
       text text NOT NULL,
       qr_code_url varchar(355) DEFAULT '' NOT NULL,
       PRIMARY KEY  (id)
     ) $charset_collate;";
 
     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
     dbDelta( $sql );
   }
}
}
 register_activation_hook( __FILE__, 'flexqr_activate_code_generator_plugin' );

 include "inc/flexqr-helpers.php";
 include "views/flexqr-create-form.php";

 