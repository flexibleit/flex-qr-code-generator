<?php
// Add a meta box to the post edit screen
add_action('add_meta_boxes', 'flexqr_code_meta_box');

function flexqr_code_meta_box() {
    add_meta_box(
        'flexqr_editor', // ID of the meta box
        'FLEXQR Code', // Title of the meta box
        'flexqr_code_meta_box_html', // Callback function to display the meta box
        ['post', 'page'], // Apply to both posts and pages
        'side', // Position
        'high' // Priority
    );
}

// The callback function to display the QR code meta box content
function flexqr_code_meta_box_html($post) {
    $flexqr_settings = get_option('flexqr_settings', ['download_button' => '', 'content' => '']);
    $download_button = isset($flexqr_settings['download_button']) ? $flexqr_settings['download_button'] : '';
    $content = isset($flexqr_settings['content']) ? $flexqr_settings['content'] : '';

    if ($post->post_status === 'publish') {
        $qr_code_url = get_permalink($post->ID);
        $shortcode_text = '[flexqr_code url="' . esc_url($qr_code_url) . '?track=true" size="155"]';
        // print_r($_SERVER['REQUEST_URI']);
        global $wpdb;
        // Generate the QR code using the QR code library.
        $qr_url = $qr_code_url. '?track=true';
        $query = "SELECT * FROM ".$wpdb->prefix."qr_codes where text=%s";
        $qr_codes = $wpdb->get_results($wpdb->prepare($query, $qr_url));

        if (count($qr_codes) == 0 || count($qr_codes) < 0) {
        $result = $wpdb->insert(
            $wpdb->prefix . 'qr_codes',
            array(
              'text' => $qr_code_url . '?track=true',
              'qr_code_url' => $qr_code_url . '?id=' . $post->ID,
            ),
            array(
              '%s',
              '%s'
            )
          );
        }
        $qr_code_html = '';
        $shortcode_html = '';

        if ($content == 1) {
            // QR code display
            $qr_code_html = '
            <div style="float:left; margin-right:20px;">
                <h3>QR Code Preview:</h3>
                <div style="margin-bottom: 10px;">' . do_shortcode($shortcode_text) . '</div>'; ?>
                <script>
                   
                    function flexQrDownloadQRCode() {
                        console.log('flex qr download')
                        var flexqr_qr_download_format = document.getElementById("flexqr_download_format").value;
                        var flexqr_qr_download_url= "<?php echo admin_url('admin-ajax.php?action=download_qr_code&post_id='.$post->ID); ?>&format="+flexqr_qr_download_format;
                        window.open(flexqr_qr_download_url)
                    }
                </script>

<?php
            if ($download_button == 1) {
                $qr_code_html .= '
                <div style="margin-bottom: 18px">
                    <form method="GET" action="' . esc_url(admin_url('admin-ajax.php?action=download_qr_code&post_id=' . $post->ID)) . '">
                    <select id="flexqr_download_format" name="format">
                    <option value="png">png</option>
                    <option value="eps">eps</option>
                    <option value="gif">gif</option>
                    <option value="jpg">jpg</option>
                    <option value="svg">svg</option>
                    </select>
                    <a onclick="flexQrDownloadQRCode()" style="border: 1px solid blue; padding: 8px 18px; border-radius: 5px; background: blue; color: white; text-decoration: none;"
                    >Download QR Code</a>
                    </form>
                </div>';
            }

            $qr_code_html .= '</div>';
            
            // Shortcode display
            $shortcode_html = '
            <div style="float:left;">
                <h3>Shortcode Generated:</h3>
                <pre style="padding: 15px; background: aliceblue; border: 1px solid paleturquoise;">' . esc_html($shortcode_text) . '</pre>
            </div>';
        }

        echo '<div style="clear:both;">' . $qr_code_html . $shortcode_html . '</div>';
    } else {
        echo '<strong>Please publish the post to generate the QR code.</strong>';
    }
}

// Shortcode function to generate the QR code based on a URL
add_shortcode('flexqr_code', function ($atts) {
    // Default shortcode attributes
    $atts = shortcode_atts(['url' => '', 'size' => '155'], $atts);

    // Validate URL
    $url = esc_url($atts['url']);
    if ($url) {
        $qr_code_url = 'https://api.qrserver.com/v1/create-qr-code/?size=' . $atts['size'] . 'x' . $atts['size'] . '&data=' . urlencode($url);
        return '<img src="' . esc_url($qr_code_url) . '" style="height:' . esc_attr($atts['size']) . 'px; width:' . esc_attr($atts['size']) . 'px;">';
    }

    return '';
});

// AJAX handler to download QR code image
add_action('wp_ajax_download_qr_code', function () {
    if (!isset($_GET['post_id'])) {
        wp_send_json_error(['message' => 'Invalid post ID'], 404);
    }

    $post_id = intval($_GET['post_id']);
    $post = get_post($post_id);

    if (!$post || $post->post_status !== 'publish') {
        wp_send_json_error(['message' => 'Post not found or not published'], 404);
    }

    $qr_code_url = get_permalink($post_id);
    
    $format = !empty($_GET['format']) ? $_GET['format'] : 'png';
    $qr_code_image_url = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&format='.$format.'&data=' . urlencode($qr_code_url);
    

    // Fetch QR code image
    $image_data = file_get_contents($qr_code_image_url);

    if ($image_data === false) {
        wp_send_json_error(['message' => 'Failed to fetch QR code'], 404);
    }
    $filename = 'qr_code.'.$format;
    // Set headers for file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($image_data));

    echo $image_data;
    exit;
});
