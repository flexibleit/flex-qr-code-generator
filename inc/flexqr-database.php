<?php

// Function to alter the table and add the new column
if (!function_exists('flexqr_alter_code_generator_table')) {
    function flexqr_alter_code_generator_table() {
      global $wpdb;
      $table_name = $wpdb->prefix . 'qr_codes';
      $column = $wpdb->get_results("SHOW COLUMNS FROM `$table_name` LIKE 'tracking'");
      if (empty($column)) {
        $sql = "ALTER TABLE $table_name 
                ADD COLUMN tracking INT DEFAULT 0 NULL, 
                ADD COLUMN tracking_details TEXT DEFAULT NULL";
        $wpdb->query($sql);
      }
    }
  }
  
  // Hook the function to run when the plugin is updated
  add_action('plugins_loaded', 'flexqr_alter_code_generator_table');

  register_activation_hook( __FILE__, 'flexqr_alter_code_generator_table' );
