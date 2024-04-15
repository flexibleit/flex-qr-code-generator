<?php
add_action('add_meta_boxes', 'flexqr_code_meta_box');

if (!function_exists('flexqr_code_meta_box')) {
    function flexqr_code_meta_box() {
        add_meta_box('flexqr_editor', 'FLEXQR Code', 'flexqr_code_meta_box_html', 'post');
    }
}

if (!function_exists('flexqr_code_meta_box_html')) {
    function flexqr_code_meta_box_html($post) {
        // Retrieve saved settings
        $flexqr_settings = get_option('flexqr_settings', array(
            'download_button' => '',
            'content' => '',
        ));

        // Access individual settings
        $download_button = isset($flexqr_settings['download_button']) ? $flexqr_settings['download_button'] : '';
        $content = isset($flexqr_settings['content']) ? $flexqr_settings['content'] : '';

        // Generate QR code based on post URL
        $qr_code_url = get_permalink($post->ID);

        // Generate shortcode text
        $shortcode_text = '[flexqr_code data-id="' . $post->ID . '" size="300" bgcolor="#ffffff" padding="5px" margin="5px"]';

        // Generate HTML for QR code and shortcode display
        $qr_code_html = '<div style="float:left; margin-right:20px;">
                            <h3>QR Code Preview:</h3>
                            <div>' . do_shortcode($shortcode_text) . '</div>
                            <br>';

        if ($content == 1) {
            // Check if download button should be displayed
            if ($download_button == 1) {
                $qr_code_html .= '<a style="border: 1px solid blue; padding: 8px 18px; border-radius: 5px; background: blue; color: white; text-decoration: none;" href="' . esc_url(admin_url('admin-ajax.php?action=download_qr_code&post_id=' . $post->ID)) . '">Download QR Code</a>';
            }

            $qr_code_html .= '</div>';

            $shortcode_html = '<div style="float:left;">
                                <h3>Shortcode Generated:</h3>
                                <pre style="padding: 15px; background: aliceblue; border: 1px solid paleturquoise; white-space: pre-wrap;">' . esc_html($shortcode_text) . '</pre>
                            </div>';
        } else {
            $qr_code_html .= '</div>';
            $shortcode_html = '';
        }

        echo '<div style="clear:both;">' . $qr_code_html . $shortcode_html . '</div>';
    }
}


// Adding shortcode
add_shortcode( 'flexqr_code', 'generate_flexqr_code' );

function generate_flexqr_code($atts) {
    $atts = shortcode_atts(array(
        'data-id' => '',
        'size' => '155',
        'bgcolor' => '#ffffff',
        'padding' => '5px',
        'margin' => '5px',
    ), $atts);

    // Generate the QR code HTML using provided attributes
    $html = '<img src="https://api.qrserver.com/v1/create-qr-code/?size=' . $atts['size'] . 'x' . $atts['size'] . '&data=' . $atts['data-id'] . '" style=" height:155px; width:155px; background-color: ' . $atts['bgcolor'] . '; padding: ' . $atts['padding'] . '; margin: ' . $atts['margin'] . ';">';

    return $html;
}

// AJAX handler to download QR code image
// AJAX handler to download QR code image
add_action('wp_ajax_download_qr_code', 'download_qr_code');
add_action('wp_ajax_nopriv_download_qr_code', 'download_qr_code');

function download_qr_code() {
    // Check if the post ID is provided
    if (isset($_GET['post_id'])) {
        $post_id = intval($_GET['post_id']);

        // Generate QR code URL
        $qr_code_url = get_permalink($post_id);

        // Generate QR code image using the provided URL
        $qr_code_image_url = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($qr_code_url);

        // Get the image data
        $image_data = file_get_contents($qr_code_image_url);

        if ($image_data !== false) {
            // Set headers to indicate PNG content and trigger download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="qr_code.png"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($image_data));

            // Output the image data
            echo $image_data;
            exit;
        } else {
            // If unable to fetch image data, return 404
            http_response_code(404);
            exit;
        }
    } else {
        // If post ID is not provided, return 404
        http_response_code(404);
        exit;
    }
}
?>
