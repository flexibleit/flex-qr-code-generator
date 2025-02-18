<?php

global $wpdb;
// Generate the QR code using the QR code library.
if (!empty($_SERVER['REQUEST_URI'])) {
  // Program to display URL of the current page.
  if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
      $link = "https";
  } else {
      $link = "http";
  }
  // Here append the common URL characters.
  $link .= "://";
  
  // Append the host(domain name, ip) to the URL.
  $link .= $_SERVER['HTTP_HOST'];
  
  // Append the requested resource location to the URL
  $link .= $_SERVER['REQUEST_URI'];
  
  // Decode the entire URL to remove URL-encoded characters
  $decoded_link = urldecode($link);
  
  // Parse the URL and its query parameters
  $parsed_url = parse_url($decoded_link);
  $query_params = [];
  
  if (isset($parsed_url['query'])) {
      parse_str($parsed_url['query'], $query_params);
  }

  // Check if track=true is in the query parameters
  if (isset($query_params['track']) && $query_params['track'] === 'true') {
      global $wpdb;

      // Prepare the query to select the row from the database
      $query = "SELECT * FROM " . $wpdb->prefix . "qr_codes WHERE text = %s";
      $qr_codes = $wpdb->get_results($wpdb->prepare($query, $decoded_link));

      if (count($qr_codes) > 0) {
          // Increment the tracking by +1
          $new_tracking = $qr_codes[0]->tracking + 1;
          // Prepare and execute the update query
          $result = $wpdb->update(
              $wpdb->prefix . 'qr_codes',
              array(
                'tracking' => $new_tracking,
              ),
              array(
                'text' => $decoded_link
              ),
              array(
                '%d' // Format for the new tracking value
              ),
              array(
                '%s' // Format for the WHERE condition
              )
          );
      }

      // Remove the track parameter and redirect
      unset($query_params['track']);
      $new_query_string = http_build_query($query_params);
      $new_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'];
      if ($new_query_string) {
          $new_url .= '?' . $new_query_string;
      }

      // Perform the redirect
      header("Location: $new_url");
      exit();
  }
}

// if (!function_exists('flexqr_code_tracking')){
//     function flexqr_code_tracking() {
       
//     }
// }


