<?php
/*
Plugin Name: No Add Admin Role
Description: Prevents all users except user ID 1 from assigning the administrator role.
Version: 1.0
Author: Sercan USLU
Author URI: https://srcnx.com
Plugin URI: https://sedeus.com
Text Domain: no-add-admin-role
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit;
}

// Dil dosyası yükleme
function naar_load_textdomain() {
    load_plugin_textdomain('no-add-admin-role', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'naar_load_textdomain');

// Kullanıcı rolü atama sayfasından 'administrator' rolünü kaldır
function naar_filter_editable_roles($roles) {
    if (get_current_user_id() !== 1) {
        unset($roles['administrator']);
    }
    return $roles;
}
add_filter('editable_roles', 'naar_filter_editable_roles');

// Kullanıcı rolü güncellenmeye çalışıldığında admin rolü engelle
function naar_prevent_admin_role_assignment($user_id) {
    if (get_current_user_id() !== 1) {
        $user = get_userdata($user_id);
        if (isset($_POST['role']) && $_POST['role'] === 'administrator') {
            // Eski rolü koru
            wp_redirect(add_query_arg([
                'message' => 'naar_no_admin'
            ], admin_url('user-edit.php?user_id=' . $user_id)));
            exit;
        }
    }
}
add_action('edit_user_profile_update', 'naar_prevent_admin_role_assignment');
add_action('personal_options_update', 'naar_prevent_admin_role_assignment');

// Uyarı mesajı göster
function naar_admin_notice() {
    if (isset($_GET['message']) && $_GET['message'] === 'naar_no_admin') {
        echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__('You are not allowed to assign the administrator role.', 'no-add-admin-role') . '</p></div>';
    }
}
add_action('admin_notices', 'naar_admin_notice');
