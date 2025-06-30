<?php
/*
Plugin Name: FormAgent.ai Integration
Plugin URI: https://wordpress.org/plugins/formagent-ai-integration/
Description: Integrate FormAgent.ai chat widget into your website by simply entering your Agent ID. The widget will be automatically embedded at the bottom of all pages.
Version: 1.1
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
Author: Your Name
Author URI: https://formagent.ai
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: formagent-wp
Domain Path: /languages
Network: false
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

// Load translation files
add_action('plugins_loaded', function() {
    load_plugin_textdomain('formagent-wp', false, dirname(plugin_basename(__FILE__)) . '/languages');
});

// Add settings menu
add_action('admin_menu', function() {
    add_options_page(
        __('FormAgent.ai Settings', 'formagent-wp'),
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
        <h1 style="color:#2d8cf0;">FormAgent.ai <?php _e('Settings', 'formagent-wp'); ?></h1>
        <form method="post" action="options.php" style="background:#fff;padding:24px 32px 16px 32px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
            <?php
            settings_fields('formagent_wp_options');
            do_settings_sections('formagent_wp');
            submit_button(__('Save Settings', 'formagent-wp'));
            ?>
        </form>
        <div style="margin-top:32px;padding:16px 24px;background:#f8f8f8;border-radius:6px;">
            <h2 style="margin-top:0;"><?php _e('Instructions', 'formagent-wp'); ?></h2>
            <ol>
                <li><?php _e('Enter your Agent ID above and save.', 'formagent-wp'); ?></li>
                <li><?php _e('The FormAgent.ai chat widget will be automatically embedded on the frontend.', 'formagent-wp'); ?></li>
            </ol>
            <p style="color:#888;font-size:13px;">FormAgent.ai <?php _e('Official Docs:', 'formagent-wp'); ?> <a href="https://docs.formagent.ai/integrations/wordpress" target="_blank">https://docs.formagent.ai/integrations/wordpress</a></p>
        </div>
    </div>
    <?php
}

// Register settings
add_action('admin_init', function() {
    register_setting('formagent_wp_options', 'formagent_wp_agent_id');
    add_settings_section('formagent_wp_section', '', null, 'formagent_wp');
    add_settings_field(
        'formagent_wp_agent_id',
        __('Agent ID', 'formagent-wp'),
        function() {
            $value = get_option('formagent_wp_agent_id', '');
            echo '<input type="text" name="formagent_wp_agent_id" value="' . esc_attr($value) . '" style="width:320px;font-size:16px;" placeholder="YOUR_AGENT_ID" />';
            echo '<p class="description">' . __('Please get your Agent ID from the FormAgent.ai dashboard.', 'formagent-wp') . '</p>';
        },
        'formagent_wp',
        'formagent_wp_section'
    );
});

// Insert script in frontend
add_action('wp_footer', function() {
    $agent_id = get_option('formagent_wp_agent_id', '');
    if ($agent_id) {
        echo '<script defer id="formagent-script" src="https://formagent.ai/embed.js" data-agent-id="' . esc_attr($agent_id) . '"></script>';
    }
}); 