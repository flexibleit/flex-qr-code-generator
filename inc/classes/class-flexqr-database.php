<?php

// Function to alter the table and add the new column
if (!class_exists('FlexQr_Database')) {
  class FlexQr_Database {
    function __construct()
    {
      // add_action('plugins_loaded', [$this,'flexqr_alter_code_generator_table']);
     $this->create_qr_codes_table();
      $this->flexqr_alter_code_generator_table();
    }

    private function create_qr_codes_table(){
      global $wpdb;
      $table_name = $wpdb->prefix . 'qr_codes';
  
      // Check if the table already exists
      if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
        // Table doesn't exist, so create it
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          text text NOT NULL,
          qr_code_url varchar(355) DEFAULT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";
         
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
      }
    }
   
   private function flexqr_alter_code_generator_table() {
      //  echo "in alter table";exit;
        global $wpdb;
        $table_name = $wpdb->prefix . 'qr_codes';
        $column = $wpdb->get_results("SHOW COLUMNS FROM `$table_name` LIKE 'tracking'");      
        if (empty($column)) {
          $sql = "ALTER TABLE $table_name 
                  ADD COLUMN tracking INT DEFAULT 0 NULL, 
                  ADD COLUMN tracking_details TEXT DEFAULT NULL";
          $wpdb->query($sql);        
        }
        $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'qr_data'");      
        if (empty($column)) {
          $sql = "ALTER TABLE $table_name 
                  ADD COLUMN qr_data TEXT DEFAULT NULL";                
          $wpdb->query($sql);        
        }
        $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'qr_code_url'");      
        if (!empty($column)) {
          $sql = "ALTER TABLE $table_name 
                  MODIFY COLUMN qr_code_url VARCHAR(355) DEFAULT NULL";       
          $wpdb->query($sql);        
        }
        $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'created_at'");      
        if (empty($column)) {
          $sql = "ALTER TABLE $table_name 
                  ADD COLUMN created_at DATETIME DEFAULT CURRENT_TIMESTAMP";                
          $wpdb->query($sql);        
        }            
        
        // $sql = "ALTER TABLE $table_name 
        //         MODIFY COLUMN created_at DATETIME DEFAULT CURRENT_TIMESTAMP";                
        // $wpdb->query($sql);        
        
        $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'logo_url'");    
       
        if (empty($column)) {
          $sql = "ALTER TABLE $table_name 
                  ADD COLUMN logo_url VARCHAR(255) DEFAULT NULL";
            $wpdb->query($sql);
      }
    }
  }
}
new FlexQr_Database();
  
  // Hook the function to run when the plugin is updated


  // register_activation_hook( __FILE__, 'flexqr_alter_code_generator_table' );