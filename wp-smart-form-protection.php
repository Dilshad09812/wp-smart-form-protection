
<?php
/**
 * Plugin Name: WP Smart Form Protection
 * Description: Lightweight honeypot spam protection for WordPress comment forms.
 * Version: 1.0.0
 * Author: Dilshad Abbas
 * License: GPL-2.0-or-later
 * Text Domain: wp-smart-form-protection
 */

if (!defined('ABSPATH')) {
    exit;
}

// Add a hidden honeypot field.
function wpsfp_add_honeypot() {
    echo '<div style="position:absolute;left:-9999px;" aria-hidden="true">
        <label for="wpsfp_website">Leave this field empty</label>
        <input type="text" name="wpsfp_website"
        id="wpsfp_website" value=""
        tabindex="-1" autocomplete="off">
    </div>';
}

add_action('comment_form_after_fields', 'wpsfp_add_honeypot');
add_action('comment_form_logged_in_after', 'wpsfp_add_honeypot');

// Block submissions when the honeypot is filled.
function wpsfp_validate_comment($commentdata) {
    if (isset($_POST['wpsfp_website']) &&
        $_POST['wpsfp_website'] !== '') {
        wp_die(
            esc_html__('Spam submission detected.', 'wp-smart-form-protection'),
            '',
            array('response' => 403)
        );
    }

    return $commentdata;
}

add_filter('preprocess_comment', 'wpsfp_validate_comment');
