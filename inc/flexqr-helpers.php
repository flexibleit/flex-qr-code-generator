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