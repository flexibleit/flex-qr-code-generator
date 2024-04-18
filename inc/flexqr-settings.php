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
        <div class='wrap'>
            <div style="display:flex; align-items:center; background:#273476; padding:15px; margin-top:12px; border-radius: 5px" >
            <h2 style="color:white; ">FlexQR Code Generator</h2>
            </div>
            <form method="post" action="">
                <table style='border-collapse: collapse; width: 20%;'>
                    <tr>
                        <td style='padding: 15px; text-align: left;'><label for="download_button" style="font-size: 15px; font-weight: 500;">Show QrCode download button:</label></td>
                        <td style='padding: 15px; text-align: left;'><input type="checkbox" name="download_button" value="1" <?php checked( $flexqr_settings['download_button'], '1' ); ?>></td>
                    </tr>
                    <tr>
                        <td style='padding: 15px; text-align: left;'><label for="content" style="font-size: 15px; font-weight: 500;">Show QrCode Content:</label></td>
                        <td style='padding: 15px; text-align: left;'><input type="checkbox" name="content" value="1" <?php checked( $flexqr_settings['content'], '1' ); ?>></td>
                    </tr>
                </table>
                <?php wp_nonce_field( 'flexqr_nonce_action', 'flexqr_nonce' ); ?>
                <button type="submit" name="submit_flexqr_settings" style="background-color: #2271b1; color: white; padding: 8px 18px; border: none; border-radius: 4px; cursor: pointer; margin-left: 15px;" >Submit</button>
            </form>
        </div>
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
