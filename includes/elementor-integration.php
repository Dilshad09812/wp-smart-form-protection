
<?php
/**
 * Elementor Pro Forms Integration
 *
 * @package WP_Smart_Form_Protection
 */

if (!defined('ABSPATH')) {
    exit;
}

function wpsfp_validate_elementor_form($record, $ajax_handler) {

    $fields = $record->get('fields');

    if (!is_array($fields)) {
        return;
    }

    if (isset($fields['wpsfp_honeypot'])) {

        $value = $fields['wpsfp_honeypot']['value'] ?? '';

        if (!is_string($value) || trim($value) !== '') {
            $ajax_handler->add_error(
                'wpsfp_honeypot',
                esc_html__(
                    'Spam submission detected.',
                    'wp-smart-form-protection'
                )
            );

            $ajax_handler->add_error_message(
                esc_html__(
                    'Your submission could not be processed.',
                    'wp-smart-form-protection'
                )
            );
        }
    }
}

add_action(
    'elementor_pro/forms/validation',
    'wpsfp_validate_elementor_form',
    10,
    2
);
