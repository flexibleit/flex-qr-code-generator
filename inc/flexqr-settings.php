<?php

if (!function_exists('flexqr_code_settings')){
    function flexqr_code_settings() {
        // Check if the form is submitted
        if ( isset( $_POST['submit_flexqr_settings'] ) ) {
            save_flexqr_settings();
        }

        // Retrieve saved settings
        $flexqr_settings = get_option( 'flexqr_settings', array(
            'download_button'    => '',
            'content'   => '',
        ) );
        ?>
        <form method="post" action="">
            <label for="download_button" style="font-size: 15px; font-weight: 500;">Show QrCode download button:</label><br>
            <input type="checkbox" name="download_button" value="1" <?php checked( $flexqr_settings['download_button'], '1' ); ?>><br>
          
            <label for="content" style="font-size: 15px; font-weight: 500;">Show QrCode Content:</label><br>
            <input type="checkbox" name="content" value="1" <?php checked( $flexqr_settings['content'], '1' ); ?>><br>
            <?php wp_nonce_field( 'flexqr_nonce_action', 'flexqr_nonce' ); ?>
            <button type="submit" name="submit_flexqr_settings" style="background-color: #2271b1; color: white; padding: 8px 18px; margin: 8px 0; border: none; border-radius: 4px; cursor: pointer;" >Submit</button>
        </form>
        <?php
    }
}

// Function to handle saving settings
function save_flexqr_settings() {
    if ( isset( $_POST['flexqr_nonce'] ) && wp_verify_nonce( $_POST['flexqr_nonce'], 'flexqr_nonce_action' ) ) {
        // Sanitize and save data
        $data = array(
            'download_button'    => isset( $_POST['download_button'] ) ? '1' : '0',
            'content'    => isset( $_POST['content'] ) ? '1' : '0',
        );
        update_option( 'flexqr_settings', $data );
    }
}
?>
