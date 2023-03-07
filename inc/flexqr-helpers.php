<?php

if (!function_exists('flexqr_valid_text')) {
   function flexqr_valid_text($input) {
      return esc_html(sanitize_text_field($input));
   }
}