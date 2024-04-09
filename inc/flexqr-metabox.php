<?php
add_action('add_meta_boxes', 'flexqr_code_meta_box');

if (!function_exists('flexqr_code_meta_box')) {
    function flexqr_code_meta_box() {
        add_meta_box('flexqr_editor', 'FLEXQR Code', 'flexqr_code_meta_box_html', 'post');
    }
}

if (!function_exists('flexqr_code_meta_box_html')) {
    function flexqr_code_meta_box_html($post) {
        // Generate QR code based on post URL
        $qr_code_url = get_permalink($post->ID);

        // Generate shortcode text
        $shortcode_text = '[flexqr_code data-id="' . $post->ID . '" size="300" bgcolor="#ffffff" padding="5px" margin="5px"]';
        
        // Generate HTML for QR code and shortcode display
        $qr_code_html = '<div style="float:left; margin-right:20px;">
                            <h3>QR Code Preview:</h3>
                            <div>' . do_shortcode($shortcode_text) . '</div>
                            <br>
                            <a style="border: 1px solid blue; padding: 8px 18px; border-radius: 5px; background: blue; color: white; text-decoration: none;" href="' . esc_url($qr_code_url) . '" download>Download QR Code</a>
                        </div>';

        $shortcode_html = '<div style="float:left;">
                                <h3>Shortcode Generated:</h3>
                                <pre>' . esc_html($shortcode_text) . '</pre>
                            </div>';

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
?>
