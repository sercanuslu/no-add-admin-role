# No Add Admin Role

**Prevent non-owner users from assigning the "Administrator" role in WordPress.**  
This plugin is a lightweight and secure way to ensure that only the user with ID 1 (usually the site owner) can assign or modify the `administrator` role. Ideal for agencies, developers, and businesses managing multi-user WordPress sites.

---

## 🔍 Description

By default, any user with appropriate capabilities (e.g., editors, shop managers, custom roles) can assign other users to the `administrator` role. This can lead to accidental or malicious privilege escalations.

**No Add Admin Role** solves this by:

- Hiding the "Administrator" role from user role dropdowns
- Preventing role changes via direct POST manipulation
- Displaying a clear admin notice when access is denied
- Supporting multilingual sites with built-in `.pot` file and Turkish translation

---

## ⚙️ Installation Instructions

1. Download the latest version of the plugin from [GitHub](https://github.com/sercanuslu/no-add-admin-role)
2. Upload the `no-add-admin-role` folder to your WordPress `/wp-content/plugins/` directory
3. Activate the plugin through the WordPress admin dashboard (`Plugins > Installed Plugins`)
4. Done! No configuration needed. It works automatically.

---

## ✨ Features

- ✅ Prevents assigning the administrator role by anyone except user ID 1
- ✅ Hides the "administrator" option from role dropdowns
- ✅ Blocks forced role changes through POST requests
- ✅ Multilingual-ready with `.pot` file and Turkish `.po/.mo` translations
- ✅ No settings screen required – plug and play

---

## 💡 Usage Example

The plugin uses the following logic to filter roles:

```php
add_filter('editable_roles', function($roles) {
    if (get_current_user_id() !== 1) {
        unset($roles['administrator']);
    }
    return $roles;
});
```

And blocks attempts via form submission:

```php
add_action('edit_user_profile_update', function($user_id) {
    if (get_current_user_id() !== 1 && isset($_POST['role']) && $_POST['role'] === 'administrator') {
        wp_redirect(add_query_arg(['message' => 'naar_no_admin'], admin_url('user-edit.php?user_id=' . $user_id)));
        exit;
    }
});
```

Admin notice on block:

```php
add_action('admin_notices', function() {
    if (isset($_GET['message']) && $_GET['message'] === 'naar_no_admin') {
        echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__('You are not allowed to assign the administrator role.', 'no-add-admin-role') . '</p></div>';
    }
});
```

---

## 🔗 Links

- 📘 **Medium Article:** [Secure Your WordPress Admin Area with the “No Add Admin Role” Plugin](https://medium.com/@iletisim_29685/secure-your-wordpress-admin-area-with-the-no-add-admin-role-plugin-564bfdfd68e8)
- 🌐 **WordpresTR Plugin Page:** [https://wordpres.tr/no-add-admin-role/](https://wordpres.tr/no-add-admin-role/)
- 🧩 **Official Plugin Page:** [https://sedeus.com](https://sedeus.com)
- 🧑‍💻 **Author Website:** [https://srcnx.com](https://srcnx.com)

---

## 👨‍💻 Author

Developed by **Sercan USLU**  
GitHub: [@sercanuslu](https://github.com/sercanuslu)  
Website: [https://srcnx.com](https://srcnx.com)

---

## 📄 License

This plugin is open-sourced under the MIT License. Use freely, fork responsibly, and contribute if you can 🤘
