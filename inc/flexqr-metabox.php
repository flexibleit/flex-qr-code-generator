<?php
// Add a meta box to the post edit screen
add_action('add_meta_boxes', 'flexqr_code_meta_box');

function flexqr_code_meta_box() {
    add_meta_box(
        'flexqr_editor', // ID of the meta box
        'FLEXQR Code', // Title of the meta box
        'flexqr_code_meta_box_html', // Callback function to display the meta box
        'post' // Post type to display the meta box on
    );
}

// The callback function to display the QR code meta box content
function flexqr_code_meta_box_html($post) {
    // Check if the post has an ID (indicating it has been saved or published)
    if ($post->ID && get_permalink($post->ID)) {
        $qr_code_url = get_permalink($post->ID); // Get the permalink for the post
        $shortcode_text = '[flexqr_code url="' . esc_url($qr_code_url) . '" size="155"]'; // Shortcode to generate QR code

        // QR code HTML with download link
        $qr_code_html = '<div style="float:left; margin-right:20px;">
            <h3>QR Code Preview:</h3>
            <div>' . do_shortcode($shortcode_text) . '</div>
            <br>
            <a style="border: 1px solid blue; padding: 8px 18px; border-radius: 5px; background: blue; color: white; text-decoration: none;" 
               href="' . esc_url(admin_url('admin-ajax.php?action=download_qr_code&post_id=' . $post->ID)) . '">Download QR Code</a>
        </div>';

        // Shortcode display
        $shortcode_html = '<div style="float:left;">
            <h3>Shortcode Generated:</h3>
            <pre style="padding: 15px; background: aliceblue; border: 1px solid paleturquoise; white-space: pre-wrap;">' . esc_html($shortcode_text) . '</pre>
        </div>';

        echo '<div style="clear:both;">' . $qr_code_html . $shortcode_html . '</div>';
    } else {
        // If the post is new or hasn't been saved, display a message
        echo '<strong>Please save the post to generate the QR code.</strong>';
    }
}

// Shortcode function to generate the QR code based on a URL
add_shortcode('flexqr_code', 'generate_flexqr_code');

function generate_flexqr_code($atts) {
    // Set default values for shortcode attributes
    $atts = shortcode_atts(array(
        'url' => '',
        'size' => '155', // QR code size
    ), $atts);

    // Generate QR code using an external service
    $qr_code_url = 'https://api.qrserver.com/v1/create-qr-code/?size=' . $atts['size'] . 'x' . $atts['size'] . '&data=' . urlencode($atts['url']);

    return '<img src="' . esc_url($qr_code_url) . '" style="height:' . esc_attr($atts['size']) . 'px; width:' . esc_attr($atts['size']) . 'px;">';
}

// AJAX handler to download QR code image
add_action('wp_ajax_download_qr_code', 'download_qr_code');
add_action('wp_ajax_nopriv_download_qr_code', 'download_qr_code');

function download_qr_code() {
    // Check if the post ID is provided
    if (isset($_GET['post_id'])) {
        $post_id = intval($_GET['post_id']); // Ensure the post ID is an integer
        $qr_code_url = get_permalink($post_id); // Get the permalink
        $qr_code_image_url = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($qr_code_url); // QR code URL
        
        // Fetch the QR code image data
        $image_data = file_get_contents($qr_code_image_url);

        if ($image_data !== false) {
            // Set headers to trigger a file download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="qr_code.png"'); // Filename for the download
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($image_data)); // Content length

            // Output the image data
            echo $image_data;
            exit;
        } else {
            http_response_code(404); // If fetching the image fails, return 404
        }
    } else {
        // If the post ID is not provided, return a 404 error
        http_response_code(404);
    }
}
?>
