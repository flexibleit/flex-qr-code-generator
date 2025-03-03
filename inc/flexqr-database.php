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
      $column = $wpdb->get_results("SHOW COLUMNS FROM `$table_name` LIKE 'qr_data'");      
      if (empty($column)) {
        $sql = "ALTER TABLE $table_name 
                ADD COLUMN qr_data TEXT DEFAULT NULL";                
        $wpdb->query($sql);        
      }
      $column = $wpdb->get_results("SHOW COLUMNS FROM `$table_name` LIKE 'qr_code_url'");      
      if (!empty($column)) {
        $sql = "ALTER TABLE $table_name 
                UPDATE COLUMN qr_code_url VARCHAR DEFAULT NULL";                
        $wpdb->query($sql);        
      }
      $column = $wpdb->get_results("SHOW COLUMNS FROM `$table_name` LIKE 'created_at'");      
      if (empty($column)) {
        $sql = "ALTER TABLE $table_name 
                ADD COLUMN created_at DATETIME DEFAULT NULL";                
        $wpdb->query($sql);        
      }
      $column = $wpdb->get_results("SHOW COLUMNS FROM `$table_name` LIKE 'logo_url'");      
      if (empty($column)) {
        $sql = "ALTER TABLE $table_name 
                ADD COLUMN logo_url VARCHAR DEFAULT NULL";   
    }
  }
}
  
  // Hook the function to run when the plugin is updated
  add_action('plugins_loaded', 'flexqr_alter_code_generator_table');

  register_activation_hook( __FILE__, 'flexqr_alter_code_generator_table' );