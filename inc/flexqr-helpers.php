<?php

use function PHPSTORM_META\type;

if (!function_exists('flexqr_valid_input')) {
   function flexqr_valid_input($input, $number=false) {
      if ($number) {
         return intval($input);
      }
      return sanitize_text_field($input);
   }
}
if (!function_exists('flexqr_admin_notice')) {
   function flexqr_admin_notice() {
      global $wpdb;
      if ($wpdb->last_error) {
          ?>
          <div class="notice notice-error">
              <p><?php esc_html_e( 'Database error: ' . $wpdb->last_error, 'flex-qr-code-generator' ); ?></p>
          </div>
          <?php
      }
   }
   add_action( 'admin_notices', 'flexqr_admin_notice' );
}
if (!function_exists('flexqr_code_shortcode')) {
function flexqr_code_shortcode( $atts ) {
   $atts = shortcode_atts( array(
       'data-id' => '',
       'size' => '200',
       'bgcolor' => 'ffffff',
       'margin' => '0',
       'padding'=> '0'
   ), $atts );

   $qrid = $atts['data-id'];
   $size = $atts['size'];
   $bgcolor = $atts['bgcolor'];
   $margin = $atts['margin'];
   $padding = $atts['padding'];
   if (empty($qrid)) {
      return '';
   }
   global $wpdb;
   // Generate the QR code using the QR code library.
   $query = "SELECT * FROM ".$wpdb->prefix."qr_codes where id=%d";
   $qr_code = $wpdb->get_results($wpdb->prepare($query, $qrid));
    // Return the QR code image as HTML.
   if (count($qr_code) > 0) {
      return '<img width="50" src="' . esc_url($qr_code[0]->qr_code_url) . '" style="width: ' . esc_attr($size) . 'px; height: ' . esc_attr($size) . 'px; border: none; padding: ' . esc_attr($padding) . '; background-color: ' . esc_attr($bgcolor) . '; margin: ' . esc_attr($margin) . ';" alt="QR code">';
   }
   return '';
}

add_shortcode( 'flexqr_code', 'flexqr_code_shortcode' );
}