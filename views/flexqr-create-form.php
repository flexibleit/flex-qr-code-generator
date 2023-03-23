<?php

if (!function_exists('flexqr_display_generator_form')) {
  function flexqr_display_generator_form() {
    echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<table><tr><td><label for="qr_code_text">Enter text to encode in QR code:</label></td>';
    echo '<td><textarea id="qr_code_text" name="qr_code_text" required></textarea></td></tr>';
   //  echo '<br><br>';
    echo '<tr><td><label for="qr_code_color">Select QR code color:</label></td>';
   echo '<td><input type="color" id="qr_code_color" name="qr_code_color"></td></tr>';
   echo '<tr><td><label for="qr_code_size">Size(150 X 150):</label></td>';
   echo '<td><input type="number" id="qr_code_size" name="qr_code_size"></td></tr>';
   echo '<tr><td><label for="qr_code_format">QR Format:</label></td>';
   echo '<td><select id="qr_code_format" name="qr_code_format">
   <option value="png">png</option>
   <option value="gif">gif</option>
   <option value="jpg">jpg</option>
   <option value="svg">svg</option>
   <option value="eps">eps</option>
   </select></td></tr>';
   echo '<tr><td><label for="qr_code_margin">Margin:</label></td>';
   echo '<td><input type="number" id="qr_code_margin" name="qr_code_margin"></td></tr>';
   echo '<tr><td colspan="2"><input type="submit" class="button button-primary" value="Generate QR Code"></td></tr></table>';
   echo '</form>';
 }
}

if (!function_exists('flexqr_code_generator_options')){
function flexqr_code_generator_options() {
  global $wpdb;

  // Display the plugin options page
  echo '<div class="wrap">';
  echo '<h2>QR Code Generator </h2>';

  echo '<h3>Create QR Code </h3>';
  echo '<p>Enter the text you want to convert into a QR code:</p>';
  flexqr_display_generator_form();

   flexqr_generate_qr_code();

  echo '<h3>Your QR Codes</h3>';
  echo '<table class="wp-list-table widefat fixed striped posts">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Text</th>';
  echo '<th>QR Code</th><th>Actions</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  $per_page = 10; // Number of items to display per page
  $page = !empty($_GET['paged']) ? absint($_GET['paged']) : 1; // Get current page number
  // echo $_GET['page']." page ";
  $offset = ($page - 1) * $per_page;
  // Query the database to retrieve all of the user's generated QR codes
  $qr_codes = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."qr_codes LIMIT ".$per_page." OFFSET $offset");

  $total_items = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."qr_codes");

  $page_links = paginate_links(array(
    'base' => add_query_arg('paged', '%#%'),
    'format' => '',
    'prev_text' => __('&laquo; Previous'),
    'next_text' => __('Next &raquo;'),
    'total' => ceil($total_items / $per_page),
    'current' => $page
  ));
  
  // $qr_codes = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "qr_codes order by id desc" );
  
  // Loop through each QR code and display it in a table row
  foreach ( $qr_codes as $qr_code ) {
    // $date_created = date('Y-m-d H:i:s', strtotime($qr_code->date_created));
    $edit_url = admin_url('admin.php?page=qrcode&action=edit&id=' . $qr_code->id);
    $delete_url = wp_nonce_url(admin_url('admin-post.php?action=delete_qrcode&id=' . $qr_code->id), 'delete_qrcode');
    echo '<tr>';
    echo '<td>' . esc_html($qr_code->text) . '</td>';
    echo '<td><img width="50" src="' . esc_url($qr_code->qr_code_url) . '" alt="QR code"></td>';
  // echo '<td><div style="background-color:' . $color . '; width:20px; height:20px;"></div></td>';
  // echo '<td><img src="' . $design . '" width="30" height="30"></td>';
  // echo '<td><img src="' . $eye . '" width="20" height="20"></td>';
  // echo '<td>' . esc_html($date_created) . '</td>';
  echo '<td><a href="' . $edit_url . '">Edit</a> | <a href="' . $delete_url . '">Delete</a> | <a href="' . esc_url($qr_code->qr_code_url) . '" download="qrcode.png">Download</a></td>';
  echo '</tr>';
  }
  
  echo '</tbody>';
  echo '</table>';
  echo '<div class="tablenav"><div class="tablenav-pages">' . $page_links . '</div></div>';
  echo '</div>';
}
}

if (!function_exists('flexqr_generate_qr_code')) {
  function flexqr_generate_qr_code() {
    global $wpdb;
  
    if ( isset( $_POST['qr_code_text'] ) && isset( $_POST['qr_code_color'] ) ) {
      $qr_code_text = flexqr_valid_input( $_POST['qr_code_text'] );
      $qr_code_color = flexqr_valid_input( $_POST['qr_code_color']);
      $qr_code_options='';
      if (!empty($qr_code_color )) {
        list($r, $g, $b) = sscanf($qr_code_color, "#%02x%02x%02x");
        $qr_code_options.= '&color='.$r.'-'. $g.'-'. $b;
      }
      $qr_code_format = flexqr_valid_input( $_POST['qr_code_format'] );
      if (!empty($qr_code_format)) $qr_code_options.= '&format='.$qr_code_format;
      $qr_code_size =  flexqr_valid_input($_POST['qr_code_size'], true);
      if (!empty($qr_code_size)) $qr_code_options.= '&size='.$qr_code_size;
      $qr_code_margin =  flexqr_valid_input($_POST['qr_code_margin'], true);
      if (!empty($qr_code_margin)) $qr_code_options.= '&margin='.$qr_code_margin;
      
      // $qr_code_design = sanitize_text_field( $_POST['qr_code_design'] );
      // $qr_code_eye_style = sanitize_text_field( $_POST['qr_code_eye_style'] );
      
      // Generate QR code URL based on selected options
      $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode( $qr_code_text ) .$qr_code_options ;
  
      // Store the QR code in the database
      $result = $wpdb->insert(
        $wpdb->prefix . 'qr_codes',
        array(
          'text' => $qr_code_text,
          'qr_code_url' => $qr_code_url
        ),
        array(
          '%s',
          '%s'
        )
      );
      if ($result == 1) {
       echo '<p>'.esc_html_e("Your QR code has been generated:", "flex-qr-code-generator").'</p>';
       echo '<img src="' . esc_url($qr_code_url) . '" alt="QR code">';
      }
    }
  }
}