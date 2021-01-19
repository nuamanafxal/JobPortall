<?php

/**
 * Plugin Name: Dynamic Visibility for Elementor
 * Description: With Dynamic Visibility for Elementor you can easily hide or show every element (also entire sections) in your page, quickly or with advanced conditions
 * Plugin URI:  https://www.dynamic.ooo/widget/dynamic-visibility/
 * Version:     3.0.1
 * Author:      Dynamic.ooo
 * Author URI:  https://www.dynamic.ooo/
 * Text Domain: dynamic-visibility-for-elementor
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

define('DVE_VERSION', '3.0.1');
define('DVE_TEXTDOMAIN', 'dynamic-visibility-for-elementor');

/**
 * Load DVE
 *
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 1.0.0
 */
function dynamic_visibility_for_elementor_load() {
    // Load localization file
    load_plugin_textdomain(DVE_TEXTDOMAIN);

    // Notice if the Elementor is not active
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', 'dynamic_visibility_for_elementor_fail_load');
        return;
    }

    // Check required version
    $elementor_version_required = '1.8.0';
    if (!version_compare(ELEMENTOR_VERSION, $elementor_version_required, '>=')) {
        add_action('admin_notices', 'dynamic_visibility_for_elementor_fail_load_out_of_date');
        return;
    }

    // Require the main plugin file
    require( __DIR__ . '/plugin.php' );
}

add_action('plugins_loaded', 'dynamic_visibility_for_elementor_load');

function dynamic_visibility_for_elementor_fail_load_out_of_date() {
    if (!current_user_can('update_plugins')) {
        return;
    }

    $file_path = 'elementor/elementor.php';

    $upgrade_link = wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=') . $file_path, 'upgrade-plugin_' . $file_path);
    $message = '<p>' . __('Dynamic Visibility for Elementor is not working because you are using an old version of Elementor.', DVE_TEXTDOMAIN) . '</p>';
    $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $upgrade_link, __('Update Elementor Now', DVE_TEXTDOMAIN)) . '</p>';

    echo '<div class="error">' . $message . '</div>';
}

function dynamic_visibility_for_elementor_fail_load() {
    $class = 'notice notice-error';
    $message = sprintf(__('You need %1$s"Elementor"%2$s for the %1$s"Dynamic Visibility for Elementor"%2$s plugin to work and updated.', DVE_TEXTDOMAIN), '<strong>', '</strong>');

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
}
