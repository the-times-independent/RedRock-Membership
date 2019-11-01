<?php
require Plugin::defaultInstance()->getPluginDir().'/src/user/map_stats.php';

function memberful_wp_all_options() {
    return array(
        'memberful_client_id' => NULL,
        'memberful_client_secret' => NULL,
        'memberful_site' => NULL,
        'memberful_api_key' => NULL,
        'memberful_webhook_secret' => NULL,
        'memberful_downloads' => array(),
        'memberful_subscriptions' => array(),
        'memberful_embed_enabled' => FALSE,
        'memberful_error_log' => array(),
        'memberful_role_active_customer' => 'subscriber',
        'memberful_role_inactive_customer' => 'subscriber',
        "memberful_default_marketing_content" => NULL
    );
}

/**
 * Options that need to be reset when disconnecting from memberful.com
 * @return array
 */
function memberful_wp_connection_options() {
    return array(
        'memberful_client_id',
        'memberful_client_secret',
        'memberful_api_key',
        'memberful_webhook_secret'
    );
}

function memberful_wp_is_connected_to_site() {
    return !! get_option('memberful_client_id', FALSE);
}

function memberful_wp_register_options() {
    foreach (memberful_wp_all_options() as $option => $default) {
        add_option($option, $default);
    }
}

function memberful_wp_option_values() {
    $config = array();

    foreach (memberful_wp_all_options() as $option => $default) {
        $value = get_option($option);

        $config[$option] = is_string($value) ? stripslashes($value) : $value;
    }

    return $config;
}

function memberful_wp_site_name() {
    $blog_name = wp_specialchars_decode(trim(get_bloginfo('name', 'Display')), ENT_QUOTES);

    return empty($blog_name) ? 'WordPress Blog' : $blog_name;
}