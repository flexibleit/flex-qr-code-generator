<?php
/**
 * Plugin Name: Flex QR Code Generator
 * Description: A simple wordpress plugin to generate and manage QR codes in WordPress.
 * Plugin URI:  https://github.com/flexibleit/flex-qr-code-generator
 * Author:      Devsbrain
 * Author URI:  https://devsbrain.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version:     1.1.7
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
  wp_enqueue_style( 'flexqr-code-generator-style', FLEXQR_CODE_GENERATOR_URI . 'flexqr-code-generator.css', array(), '1.1.7' );
  wp_enqueue_script( 'flexqr-code-generator-script', FLEXQR_CODE_GENERATOR_URI . 'flexqr-code-generator.js', array( 'jquery' ) );
  wp_enqueue_script( 'jquery-script', "https://code.jquery.com/jquery-3.6.4.min.js", array( 'jquery' ), true );
}
add_action( 'admin_enqueue_scripts', 'flexqr_code_generator_scripts' );

}
// Add an action hook to add a custom menu item in the WordPress admin area

if (!function_exists('flexqr_code_generator_menu')){
  function flexqr_code_generator_menu() {
    add_menu_page('QR Code Generator Options', 'Flex QR Code', 'manage_options', 'flexqr-code-generator', 'flexqr_code_generator_options', 'dashicons-screenoptions' );

    add_submenu_page('flexqr-code-generator', 'Settings', 'Setting ', 'manage_options', 'flexqr-code-settings', 'flexqr_code_settings');

    // add_submenu_page('flexqr-code-generator', 'Tracking', 'Tracking ', 'manage_options', 'flexqr-code-tracking', 'flexqr_code_tracking');

    // $page = add_options_page( 'QR Code Generator Options', 'QR Code Generator', 'manage_options', 'flexqr-code-generator', 'flexqr_code_generator_options' );
    // add_action( "admin_print_styles-{$page}", 'flexqr_code_generator_scripts' );
  }
  add_action( 'admin_menu', 'flexqr_code_generator_menu' );
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

 require_once FLEXQR_CODE_GENERATOR_PATH.'vendor/autoload.php';
 require_once FLEXQR_CODE_GENERATOR_PATH.'inc/classes/class-flexqr-qrcode.php';
 include "inc/flexqr-helpers.php";
 include "inc/flexqr-metabox.php";
 include "inc/flexqr-settings.php";
 include "inc/flexqr-track.php";
 include "views/flexqr-create-form.php";

 // Alter database
 include "inc/flexqr-database.php";
 
 // Handle the AJAX request
function qr_code_generator_ajax() {
  if ( isset( $_POST['qr_code_text'] ) ) {
    // $qr_code_text = flexqr_valid_input( $_POST['qr_code_text'] );
    // $qr_code_color = flexqr_valid_input( $_POST['qr_code_color']);
    // $qr_code_options='';
    // if (!empty($qr_code_color )) {
    //   list($r, $g, $b) = sscanf($qr_code_color, "#%02x%02x%02x");
    //   $qr_code_options.= '&color='.$r.'-'. $g.'-'. $b;
    // }
    // $qr_code_format = flexqr_valid_input( $_POST['qr_code_format'] );
    // if (!empty($qr_code_format)) $qr_code_options.= '&format='.$qr_code_format;
    // $qr_code_size =  flexqr_valid_input($_POST['qr_code_size'], true);
    // if (!empty($qr_code_size)) $qr_code_options.= '&size='.$qr_code_size;
    // $qr_code_margin =  flexqr_valid_input($_POST['qr_code_margin'], true);
    // if (!empty($qr_code_margin)) $qr_code_options.= '&margin='.$qr_code_margin;

    // $qrCode = $qrCodeGenerator->generateQRCode();
    $uploads = wp_upload_dir();
    
    if (!empty($_FILES['input_logo']['tmp_name'])) {
        $uploaded_logo = wp_handle_upload($_FILES['input_logo'], ['test_form' => false]);
        
    }
     $qrCodeGenerator = new FlexQr_QRCode();
    $qr_code_format = $qrCodeGenerator->generate(true);
      $response = [
        'qrCode' => $qr_code_format,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
  }
  wp_die();
}
add_action('wp_ajax_flexqr_generate_qr', 'qr_code_generator_ajax');
add_action('wp_ajax_nopriv_flexqr_generate_qr', 'qr_code_generator_ajax');
 