<?php

global $wpdb;
// Generate the QR code using the QR code library.
if(!empty($_SERVER['REQUEST_URI'])){
    // Program to display URL of current page.
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
        $link = "https";
    }else{
        $link = "http";
    }
    // Here append the common URL characters.
    $link .= "://";
    
    // Append the host(domain name, ip) to the URL.
    $link .= $_SERVER['HTTP_HOST'];
    
    // Append the requested resource location to the URL
    $link .= $_SERVER['REQUEST_URI'];

    $query = "SELECT * FROM ".$wpdb->prefix."qr_codes WHERE qr_code_url = %s";
    $qr_codes = $wpdb->get_results($wpdb->prepare($query, $link));

    if (count($qr_codes) > 0) {
        $new_tracking = $qr_codes[0]->tracking + 1; // Increment the tracking by +1
        $result = $wpdb->update(
            $wpdb->prefix . 'qr_codes',
            array(
              'tracking' => $new_tracking,
            ),
            array(
              'qr_code_url' => $link
            ),
            array(
              '%d' // Format for the new tracking value
            ),
            array(
              '%s' // Format for the WHERE condition
            )
        );
    }
}

// if (!function_exists('flexqr_code_tracking')){
//     function flexqr_code_tracking() {
       
//     }
// }


