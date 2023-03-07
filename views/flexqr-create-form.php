<?php


function display_qr_code_generator_form() {
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
  // echo '<br><br>';
  // echo '<tr><td><label for="qr_code_design">Select QR code design:</label></td>';
  // // echo '<br>';
  // echo '<td><img src="' . FLEXQR_CODE_GENERATOR_URI . 'square.png" width="50" alt="Square design" class="flexqr-code-option qr-code-design" onclick="document.getElementById(\'qr_code_design\').value=\'square\';">';
  // echo '<img src="' . FLEXQR_CODE_GENERATOR_URI . 'round.png" width="50" alt="Round design" class="flexqr-code-option qr-code-design" onclick="document.getElementById(\'qr_code_design\').value=\'round\';">';
  // echo '<input type="hidden" id="qr_code_design" name="qr_code_design"></td></tr>';
  // echo '<br><br>';
  // echo '<tr><td><label for="qr_code_eye_style">Select QR code eye style:</label></td>';
  // // echo '<br>';
  // echo '<td><img src="' . FLEXQR_CODE_GENERATOR_URI . 'dot.png" width="50" alt="Dots eye style" class="flexqr-code-option qr-code-eye-style" onclick="document.getElementById(\'qr_code_eye_style\').value=\'dots\';">';
  // echo '<img src="' . FLEXQR_CODE_GENERATOR_URI . 'circle-eye.png" width="50" alt="Circles eye style" class="flexqr-code-option qr-code-eye-style" onclick="document.getElementById(\'qr_code_eye_style\').value=\'circles\';">';
  // echo '<input type="hidden" id="qr_code_eye_style" name="qr_code_eye_style"/></td></tr>';
  // echo '<br><br>';
  echo '<tr><td colspan="2"><input type="submit" class="button button-primary" value="Generate QR Code"></td></tr></table>';
  echo '</form>';
}

function flexqr_code_generator_options() {
  global $wpdb;

  // Display the plugin options page
  echo '<div class="wrap">';
  echo '<h2>QR Code Generator </h2>';

  echo '<h3>Create QR Code </h3>';
  echo '<p>Enter the text you want to convert into a QR code:</p>';
  display_qr_code_generator_form();

   flexqr_generate_qr_code();

  echo '<h3>Your QR Codes</h3>';
  echo '<table class="wp-list-table widefat fixed striped posts">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Text</th>';
  echo '<th>QR Code</th>';
  echo '<th>Download</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  
  // Query the database to retrieve all of the user's generated QR codes
  $qr_codes = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "qr_codes" );
  
  // Loop through each QR code and display it in a table row
  foreach ( $qr_codes as $qr_code ) {
  echo '<tr>';
  echo '<td>' . $qr_code->text . '</td>';
  echo '<td><img width="50" src="' . $qr_code->qr_code_url . '" alt="QR code"></td>';
  echo '<td><a href="' . $qr_code->qr_code_url . '" download="qrcode.png">Download</a></td>';
  echo '</tr>';
  }
  
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
}

function flexqr_generate_qr_code() {
  global $wpdb;

  if ( isset( $_POST['qr_code_text'] ) && isset( $_POST['qr_code_color'] ) ) {
    $qr_code_text = sanitize_text_field( $_POST['qr_code_text'] );
    $qr_code_color = sanitize_text_field( $_POST['qr_code_color'] );
    $qr_code_options='';
    if (!empty($qr_code_color )) {
      list($r, $g, $b) = sscanf($qr_code_color, "#%02x%02x%02x");
      $qr_code_options.= '&color='.$r.'-'. $g.'-'. $b;
    }
    $qr_code_format = sanitize_text_field( $_POST['qr_code_format'] );
    if (!empty($qr_code_format)) $qr_code_options.= '&format='.$qr_code_format;
    $qr_code_size =  $_POST['qr_code_size'];
    if (!empty($qr_code_size)) $qr_code_options.= '&size='.$qr_code_size;
    $qr_code_margin =  $_POST['qr_code_margin'];
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
          //  echo $wpdb->insert_id;
     } else {
           echo print_r($wpdb->last_error);exit;
     }
     echo '<p>Your QR code has been generated:</p>';
     echo '<img src="' . $qr_code_url . '" alt="QR code">';
  }
}