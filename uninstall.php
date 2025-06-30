<?php
/**
 * Uninstall script for FormAgent.ai Integration
 * 
 * This file is executed when the plugin is deleted from the WordPress admin.
 * It removes all plugin data from the database.
 */

// Prevent direct access
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit('Direct access denied.');
}

// Delete plugin options
delete_option('formagent_wp_agent_id');

// For multisite installations
if (is_multisite()) {
    $sites = get_sites(array(
        'fields' => 'ids',
        'number' => 0
    ));
    
    foreach ($sites as $site_id) {
        switch_to_blog($site_id);
        delete_option('formagent_wp_agent_id');
        restore_current_blog();
    }
} 