<?php
/*
Plugin Name: FormAgent.ai Integration
Plugin URI: https://wordpress.org/plugins/formagent-ai-integration/
Description: Integrate FormAgent.ai chat widget into your website by simply entering your Agent ID. The widget will be automatically embedded at the bottom of all pages.
Version: 1.1
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.4
Author: FormAgent.ai
Author URI: https://formagent.ai
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: formagent-ai-integration
Domain Path: /languages
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

// Load translation files
add_action('plugins_loaded', function() {
    load_plugin_textdomain('formagent-ai-integration', false, dirname(plugin_basename(__FILE__)) . '/languages');
});

// Sanitize Agent ID input
function formagent_wp_sanitize_agent_id($input) {
    // Remove any HTML tags and trim whitespace
    $sanitized = sanitize_text_field($input);
    
    // Allow only alphanumeric characters, hyphens, and underscores
    $sanitized = preg_replace('/[^a-zA-Z0-9_-]/', '', $sanitized);
    
    return $sanitized;
}

// Add settings menu
add_action('admin_menu', function() {
    add_options_page(
        __('FormAgent.ai Settings', 'formagent-ai-integration'),
        'FormAgent.ai',
        'manage_options',
        'formagent-wp',
        'formagent_wp_settings_page'
    );
});

// Settings page content
function formagent_wp_settings_page() {
    ?>
    <div class="wrap" style="max-width:600px;">
        <h1 style="color:#2d8cf0;">FormAgent.ai <?php esc_html_e('Settings', 'formagent-ai-integration'); ?></h1>
        <form method="post" action="options.php" style="background:#fff;padding:24px 32px 16px 32px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
            <?php
            settings_fields('formagent_wp_options');
            do_settings_sections('formagent_wp');
            submit_button(__('Save Settings', 'formagent-ai-integration'));
            ?>
        </form>
        <div style="margin-top:32px;padding:16px 24px;background:#f8f8f8;border-radius:6px;">
            <h2 style="margin-top:0;"><?php esc_html_e('Instructions', 'formagent-ai-integration'); ?></h2>
            <ol>
                <li><?php esc_html_e('Enter your Agent ID above and save.', 'formagent-ai-integration'); ?></li>
                <li><?php esc_html_e('The FormAgent.ai chat widget will be automatically embedded on the frontend.', 'formagent-ai-integration'); ?></li>
            </ol>
            <p style="color:#888;font-size:13px;">FormAgent.ai <?php esc_html_e('Official Docs:', 'formagent-ai-integration'); ?> <a href="https://docs.formagent.ai/integrations/wordpress" target="_blank">https://docs.formagent.ai/integrations/wordpress</a></p>
        </div>
    </div>
    <?php
}

// Register settings
add_action('admin_init', function() {
    register_setting('formagent_wp_options', 'formagent_wp_agent_id', array(
        'sanitize_callback' => 'formagent_wp_sanitize_agent_id'
    ));
    add_settings_section('formagent_wp_section', '', null, 'formagent_wp');
    add_settings_field(
        'formagent_wp_agent_id',
        __('Agent ID', 'formagent-ai-integration'),
        function() {
            $value = get_option('formagent_wp_agent_id', '');
            echo '<input type="text" name="formagent_wp_agent_id" value="' . esc_attr($value) . '" style="width:320px;font-size:16px;" placeholder="YOUR_AGENT_ID" />';
            echo '<p class="description">' . esc_html__('Please get your Agent ID from the FormAgent.ai dashboard.', 'formagent-ai-integration') . '</p>';
        },
        'formagent_wp',
        'formagent_wp_section'
    );
});

// Enqueue FormAgent.ai script in frontend
add_action('wp_enqueue_scripts', function() {
    $agent_id = get_option('formagent_wp_agent_id', '');
    if ($agent_id) {
        // Register and enqueue a custom script to load FormAgent.ai
        wp_register_script(
            'formagent-loader',
            false,
            array(),
            '1.0',
            true
        );
        wp_enqueue_script('formagent-loader');
        
        // Add inline script to load FormAgent.ai with proper data attribute
        wp_add_inline_script(
            'formagent-loader',
            'document.addEventListener("DOMContentLoaded", function() {
                var script = document.createElement("script");
                script.src = "https://formagent.ai/embed.js";
                script.defer = true;
                script.id = "formagent-script";
                script.setAttribute("data-agent-id", "' . esc_js($agent_id) . '");
                document.head.appendChild(script);
            });'
        );
    }
}); 