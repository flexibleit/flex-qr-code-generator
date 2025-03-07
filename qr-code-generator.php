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
class FlexQrCodeGenerator
{
  function __construct()
  {
    register_activation_hook(__FILE__, [$this, 'flexqr_code_generator_activate']);
    register_deactivation_hook(__FILE__, [$this, 'flexqr_code_generator_deactivate']);
    add_action('init', array($this, 'flexqr_includes'));
    add_action('admin_enqueue_scripts', [$this, 'flexqr_code_generator_scripts']);
    add_action('admin_menu', [$this, 'flexqr_code_generator_menu']);

    add_action('wp_ajax_flexqr_generate_qr', [$this, 'qr_code_generator_ajax']);
    add_action('wp_ajax_nopriv_flexqr_generate_qr', [$this, 'qr_code_generator_ajax']);

    add_action('wp_ajax_flexqr_generate_qr_with_id', [$this, 'generate_qr_with_id']);
    add_action('wp_ajax_nopriv_flexqr_generate_qr_with_id', [$this, 'generate_qr_with_id']);


    // Altering the footer.
    // add_action('admin_init', function () {
    //   add_filter('admin_footer_text', function () {
    //     echo "";
    //   }, 11);
    //   add_filter('update_footer', function () {
    //     echo "";
    //   }, 11);
    // });

  }

  public function flexqr_includes()
  {
    require_once FLEXQR_CODE_GENERATOR_PATH . 'vendor/autoload.php';
    require_once FLEXQR_CODE_GENERATOR_PATH . 'inc/classes/class-flexqr-qrcode.php';
    include "inc/flexqr-helpers.php";
    include "inc/flexqr-metabox.php";
    include "inc/flexqr-settings.php";
    include "inc/flexqr-track.php";
    include "views/flexqr-create-form.php";


  }

  function flexqr_code_generator_activate()
  {
    // Code to run when plugin is activated
    // Alter database
    include FLEXQR_CODE_GENERATOR_PATH . "inc/classes/class-flexqr-database.php";
  }

  function flexqr_code_generator_deactivate()
  {
    // Code to run when plugin is deactivated
  }

  public function flexqr_code_generator_scripts()
  {
    wp_enqueue_style('flexqr-code-generator-style', FLEXQR_CODE_GENERATOR_URI . 'flexqr-code-generator.css', array(), '1.1.7');
    wp_enqueue_script('flexqr-code-generator-script', FLEXQR_CODE_GENERATOR_URI . 'flexqr-code-generator.js', array('jquery'));
    wp_enqueue_script('jquery-script', "https://code.jquery.com/jquery-3.6.4.min.js", array('jquery'), true);

    wp_enqueue_script('flexqr-admin-scripts', plugin_dir_url(__FILE__) . 'build/admin.js', ['wp-element'], wp_rand(), true);
    wp_enqueue_style('flexqr-admin-style', plugin_dir_url(__FILE__) . 'build/index.css');
    wp_localize_script('flexqr-admin-scripts', 'flexQrApi', [
      'apiUrl' => home_url('/wp-json'),
      'nonce' => wp_create_nonce('wp_rest'),
    ]);

  }

  function flexqr_code_generator_menu()
  {
    add_menu_page('QR Code Generator Options', 'Flex QR Code', 'manage_options', 'flexqr-code-generator', 'flexqr_code_generator_options', 'dashicons-screenoptions');

    add_submenu_page('flexqr-code-generator', 'Settings', 'Setting ', 'manage_options', 'flexqr-code-settings', 'flexqr_code_settings');

    // add_submenu_page('flexqr-code-generator', 'Tracking', 'Tracking ', 'manage_options', 'flexqr-code-tracking', 'flexqr_code_tracking');

    // $page = add_options_page( 'QR Code Generator Options', 'QR Code Generator', 'manage_options', 'flexqr-code-generator', 'flexqr_code_generator_options' );
    // add_action( "admin_print_styles-{$page}", 'flexqr_code_generator_scripts' );
  }


  function qr_code_generator_ajax()
  {

    if (!empty($_POST['qr_code_text']) && $_POST['store_data'] == 1) {
      // Store the QR code in the database
      global $wpdb;
      // if( isset($_POST['qr_code_logo_path'])){
      //   $qr_code_logo_path = $_POST['qr_code_logo_path'];
      // print_r($_POST);exit;
      // }

      // echo 'before inserting'.$_POST['qr_code_logo_path'];exit;
      $input_data = array(
        'text' => $_POST['qr_code_text'],
        'qr_code_url' => $_POST['qr_code_url'],
        'qr_data' => json_encode([
          'qr_code_text' => $_POST['qr_code_text'],
          'qr_code_size' => $_POST['qr_code_size'],
          'eye_color' => $_POST['eye_color'],
          'dot_color' => $_POST['dot_color'],
          'circleRadius' => $_POST['circleRadius'],
          'version' => $_POST['version'],
          'qr_code_margin' => $_POST['qr_code_margin'],
          // 'qr_code_input' => $_POST['qr_code_input'],
          'drawCircularModules' => $_POST['drawCircularModules'],
          'qr_code_url' => $_POST['qr_code_url']
        ])
      );

      if (!empty($_POST['qr_code_logo_path']) && $_POST['qr_code_logo_path'] != 'null') {
        $parts = explode('wp-content', $_POST['qr_code_logo_path']);
        $lastPart = trim($parts[1], '/');
        $lastPart = str_replace(['uploads/'], '', $lastPart);
        $input_data['logo_url'] = $lastPart;
      }

      $result = $wpdb->insert(
        $wpdb->prefix . 'qr_codes',
        $input_data,
      );
    } else if (isset($_POST['qr_code_text'])) {
      $uploads = wp_upload_dir();

      if (!empty($_FILES['input_logo']['tmp_name'])) {
        $uploaded_logo = wp_handle_upload($_FILES['input_logo'], ['test_form' => false]);
        print_r($_FILES['input_logo']);
      }

      $qrCodeGenerator = new FlexQr_QRCode();

      header('Content-Type: application/json');


      // dowload type is eps
      if (isset($_POST['qr_code_format']) && $_POST['qr_code_format'] === 'eps') {


        list($qr_code, $logo) = $qrCodeGenerator->generate('eps');

        $response = [
          'qrCode' => $qr_code,
          'logo' => $logo,
        ];

        // echo json_encode($response);
        echo json_encode($response);

      } else {
        // download type is not eps so default export svg
        // list($qr_code, $logo) = $qrCodeGenerator->generate(true);

        list($qr_code, $logo) = $qrCodeGenerator->generate();

        $response = [
          'qrCode' => $qr_code,
          'logo' => $logo,
        ];
        echo json_encode($response);
      }


    }
    wp_die();
  }

  function generate_qr_with_id()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . 'qr_codes';

    if (!isset($_POST['id'])) {
      wp_send_json_error(['message' => 'Missing ID parameter'], 400);
    }

    $id = intval($_POST['id']);

    $fetched_data = $wpdb->get_row($wpdb->prepare("SELECT qr_data, logo_url FROM $table_name WHERE id = %d", $id), ARRAY_A);


    $logo_url = WP_CONTENT_DIR . '/uploads/' . $fetched_data['logo_url'];

    // var_dump($logo_url);
    error_log($logo_url);

    $data = json_decode($fetched_data['qr_data'], true);

    $data['qr_code_logo'] = $logo_url;

    $qrCodeGenerator = new FlexQr_QRCode($data);

    list($qr_code, $logo) = $qrCodeGenerator->generate();

    $response = [
      'qrCode' => $qr_code,
      'logo' => $logo,
    ];

    wp_send_json_success($response);
  }

}

new FlexQrCodeGenerator();