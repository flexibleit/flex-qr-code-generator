<?php

// require_once __DIR__.'/../vendor/autoload.php';
// require_once __DIR__.'/../inc/flexqr-generate.php';

if (!function_exists('flexqr_display_generator_form')) {
  function flexqr_display_generator_form()
  {
    /* echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post" id="qrForm">';?>
    <input type="hidden" name="action" value="flexqr_generate_qr">
            <?php wp_nonce_field('qrcode_nonce', 'qrcode_nonce'); 
    echo '<table><tr><td><label for="flexqrcode_code_text">Enter text to encode in QR code:</label></td>';  
    echo '<td>
    <textarea id="flexqrcode_code_text" placeholder="text/url/anything"  name="qr_code_text" required style="padding: 6px 20px; margin: 8px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; width: 300px;"></textarea>
  </td>
  <td>
    <select id="flexqrcode_select_page_option" name="qr_code_input" style="padding: 6px 20px; margin: 8px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; width: 300px;">
      <option value="">Select</option>
      <option value="page">page</option>
      <option value="post">post</option>';
      if (function_exists('wc_get_products')) {
        echo '<option value="product">product</option>';
      }
      echo' </select>
  </td>
  <td id="flexqrcode_input_page">
  <select name="page-dropdown" style="padding: 6px 20px; margin: 8px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; width: 300px;">
      <option value="">' . esc_attr( __( 'Select page' ) ) . '</option>';
      
    $pages = get_pages();
    foreach ( $pages as $page ) {
    echo '<option value="' . get_page_link( $page->ID ) . '">' . $page->post_title . '</option>';
    }

    echo '</select>
    </td>
    <td id="flexqrcode_input_post">
    <select name="page-dropdown" style="padding: 6px 20px; margin: 8px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; width: 300px;">
      <option value="">' . esc_attr( __( 'Select Posts' ) ) . '</option>';
      
    $posts = get_posts();
    foreach ( $posts as $post ) {
    echo '<option value="' . get_permalink( $post->ID ) . '">' . $post->post_title . '</option>';
    }
    echo '</select>
    </td>
    <td id="flexqrcode_input_product">
    <select name="page-dropdown" style="padding: 6px 20px; margin: 8px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; width: 300px;">
      <option value="">' . esc_attr( __( 'Select Product' ) ) . '</option>';
      $args = array(

        'limit' => 10,
        'orderby' => 'date',
        'order' => 'DESC'
    
    );
    if (function_exists('wc_get_products')) {
    $products = wc_get_products($args);
    foreach ( $products as $product ) {
    echo '<option value="' .  get_permalink( $product->get_id() ) . '">' . $product->get_name() . '</option>';
    }
    }
    echo '</select>
    </td>
</tr>';


   //  echo '<br><br>';
    // echo '<tr><td><label for="qr_code_color">Select QR code color:</label></td>';
  //  echo '<td><input type="color" id="qr_code_bg_color" name="qr_code_bg_color" style=" display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; "></td></tr>';
   ?>
    <!-- <tr><td><label for="finderDark">Finder Pattern Color (Dark):</label></td>
    <td><input type="color" id="finderDark" name="finderDark" value="#000000"></td></tr>

    <tr><td><label for="finderDot">Finder Dot Color:</label></td>
    <td><input type="color" id="finderDot" name="finderDot" value="#FF0000"></td></tr>

    <tr><td><label for="alignmentDark">Alignment Pattern Color (Dark):</label></td>
    <td><input type="color" id="alignmentDark" name="alignmentDark" value="#00FF00"></td></tr> -->

    <tr><td><label for="eye_color">Eye Color:</label></td>
    <td><input type="color" id="eye_color" name="eye_color"></td></tr>

    <tr><td><label for="dot_color">Dot Color:</label></td>
    <td><input type="color" id="dot_color" name="dot_color"></td></tr>

    <!-- <tr><td><label for="background_color">background_color:</label></td>
    <td><input type="color" id="background_color" name="background_color"></td></tr> -->

    <label for="version">Select QR Code Version:</label>
    <select id="version" name="version">
        <?php for ($i = 7; $i <= 10; $i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endfor; ?>
    </select><br><br>
    
    
    <label for="circleRadius">Circle Radius (0.5 to 0.75):</label>
    <input type="number" id="circleRadius" name="circleRadius" min="0.5" max="0.75" step="0.05" value="0.5"><br><br>

    <tr><td><label for="drawCircularModules">Draw Circular Modules:</label></td>    
        <td><input style="width: 1px;" type="radio" id="image1" name="drawCircularModules" value="1">
        <label for="image1"><img src="<?php echo plugin_dir_url(__FILE__); ?>../dot.png" alt="Image 1" class="module-preview"></label></td>
        <td><input style="width: 1px;" type="radio" id="image2" name="drawCircularModules" value="0" checked>
        <label for="image2"><img src="<?php echo plugin_dir_url(__FILE__); ?>../round.png" alt="Image 2" class="module-preview"></label></td></tr>

   <?php
   echo '<tr><td><label for="qr_code_size">Size(150 X 150):</label></td>';
   echo '<td><input type="number" id="qr_code_size" name="qr_code_size" style="padding: 6px 20px; margin: 8px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; width: 300px;"></td></tr>';
   echo '<tr><td><label for="qr_code_format">QR Format:</label></td>';
   echo '<td><select id="qr_code_format" name="qr_code_format" style="padding: 6px 20px; margin: 8px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; width: 300px;">
   <option value="png">png</option>
   <option value="gif">gif</option>
   <option value="jpg">jpg</option>
   <option value="svg">svg</option>
   <option value="eps">eps</option>
   </select></td></tr>';
   echo '<tr><td><label for="qr_code_margin">Margin:</label></td>';
   echo '<td><input type="number" id="qr_code_margin" name="qr_code_margin" style="padding: 6px 20px; margin: 8px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; width: 300px;"></td></tr>';
   echo '<tr><td colspan="2"><input type="submit" class="button button-primary" style="padding: 7px 20px; margin: 8px 0;" value="Generate QR Code"></td></tr></table>';
   echo '</form>';  

   echo '<div id="qrCodeOutput"></div>';
*/



  }
}

if (!function_exists('flexqr_delete_qr')) {
  function flexqr_delete_qr()
  {
    global $wpdb;
    if (!empty($_POST['action']) && $_POST['action'] == 'delete_qrcode' && !empty($_POST['qrid'])) {
      $id = flexqr_valid_input($_POST['qrid']);
      $table_name = $wpdb->prefix . 'qr_codes'; // replace 'qr_codes' with your table name
      // delete the row with the given ID
      $result = $wpdb->delete($table_name, array('id' => $id), array('%d'));
      if ($result === false) {
        // handle error
        return false;
      } else {
        // return true;
        wp_redirect(admin_url('admin.php?page=flexqr-code-generator'));
        exit;
      }
    }

  }
}

if (!function_exists('flexqr_code_generator_options')) {
  function flexqr_code_generator_options()
  {
    global $wpdb;
    flexqr_delete_qr();

    // Display the plugin options page
    echo '<div class=" wrap"><h2 class="wrap-container"></h2>';
    include_once "flexqr-top-header.php";
    echo '<div class="flex-qr-code-wrapper"><div id="flex_qr_code_input"></div></div>';
    // echo '<div class="flex-qr-code-form"><h3>Create QR Code </h3>';
    // echo '<p>You can create QR code for any texts or links. There is option to select page, post or product link. You can select easily from dropdown. Here is also options for select QR code color, size, format and margin. After creating you can see the qr code under table. You can easily copy the Qr code and share it as your own.</p>';
    // flexqr_display_generator_form();
    // flexqr_generate_qr_code();

    echo '</div>';
    echo '<h3>Your QR Codes</h3>';
    echo '<table class="wp-list-table widefat fixed striped posts">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Text</th>';
    echo '<th>Scanned</th><th>QR Code</th><th>Shortcode</th><th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    $per_page = 10; // Number of items to display per page
    $page = !empty($_GET['paged']) ? absint($_GET['paged']) : 1; // Get current page number
    // echo $_GET['page']." page ";
    $offset = ($page - 1) * $per_page;
    // Query the database to retrieve all of the user's generated QR codes
    $qr_codes = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "qr_codes order by id desc LIMIT " . $per_page . " OFFSET $offset");

    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "qr_codes");

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
    foreach ($qr_codes as $qr_code) {
      // $date_created = date('Y-m-d H:i:s', strtotime($qr_code->date_created));
      echo '<tr>';
      echo '<td>' . esc_html($qr_code->text) . '</td>';
      echo '<td>' . esc_html($qr_code->tracking) . '</td>';


      // if (strpos($qr_code->qr_code_url, 'https://api.qrserver.com') !== false ) {
      //   // Check if the URL has an 'eps' extension
      //   if (strpos($qr_code->qr_code_url, 'eps') !== false) {
      //       echo 'No preview for eps file';
      //   } else {
      //       echo '<img width="50" src="' . esc_url($qr_code->qr_code_url) . '" alt="QR code">';

      //   }
      // }
      // else {
      //     echo do_shortcode('[flexqr_code url="' . esc_url($qr_code->qr_code_url) . '" size="50" bgcolor="#ffffff" padding="5px" margin="5px"]');
      // }

      // echo '<svg width="300px" src="' . $GLOBALS["out"] . '" alt="QR code" >';

      // if (strpos($qr_code->qr_code_url, 'https://api.qrserver.com') !== false) {
      //     echo '<td>[flexqr_code data-id="' . esc_html($qr_code->id) . '" size="300" bgcolor="#ffffff" padding="5px" margin="5px"]</td>';
      // } else {
      //     echo '<td>[flexqr_code url="' . esc_url($qr_code->qr_code_url) . '" size="155"]</td>';
      // }


      // Qr Code Fetching
      $response = wp_remote_post(admin_url('admin-ajax.php'), [
        'body' => [
          'action' => 'flexqr_generate_qr_with_id',
          'id' => $qr_code->id,
        ]
      ]);

      if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo "Something went wrong: $error_message";
      } else {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        // var_dump($data);
      }

      $base64SVG = str_replace("data:image/svg+xml;base64,", "", $data['data']['qrCode']);

      $svgContent = base64_decode($base64SVG);

      echo '<td>';
      echo '<div class="svg-container">';
      echo $svgContent;
      echo '</div>';
      echo '</td>';


      // ShortCode Fetching

      $qr_data = json_decode($qr_code->qr_data);
      $qr_data_str = ' ';

      foreach ($qr_data as $key => $value) {
        $qr_data_str .= '' . $key . '=' . '"' . $value . '"' . ' ';
      }

      echo '<td>[flexqr_code data-id="' . esc_html($qr_code->id) . '"' . $qr_data_str . ']</td>';

      // Extract the ID from the qr_code_url
      $url_components = parse_url($qr_code->qr_code_url);

      if (isset($url_components['query'])) {
        parse_str($url_components['query'], $params);
        $qr_id = isset($params['id']) ? intval($params['id']) : 0;
      } else {
        $qr_id = 0; // Default value or handle the error as needed
      }

      $confirm_msg = "'are you sure?'";
      echo '<td>
      <form style="display: inline-block;" method="post" action="">
        <input type="hidden" name="qrid" value="' . esc_html($qr_code->id) . '" />
        <input type="hidden" name="action" value="delete_qrcode" />
        <button style="border:none;background:none;color:#2371b1;" onclick="return confirm(' . $confirm_msg . ')" type="submit">Delete</button>
      </form> | ';

      if (strpos($qr_code->qr_code_url, 'https://api.qrserver.com') !== false) {
        echo '<a href="' . esc_url($qr_code->qr_code_url) . '" download="qrcode.png">Download</a></td>';
      } else {
        echo '<a href="' . esc_url(admin_url('admin-ajax.php?action=download_qr_code&post_id=' . $qr_id)) . '" download="qrcode.png">Download</a></td>';
      }
      echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '<div class="tablenav"><div class="tablenav-pages">' . $page_links . '</div></div>';
    echo '</div>';
  }
}

