<?php

    function stori_redirect_to_admin() {        
        global $pagenow;
        
        if (is_user_logged_in() || $pagenow == 'wp-login.php' || REST_REQUEST == true) {
            return;
        }

        wp_redirect('wp-login.php', 302);
    }

    add_action('init', 'stori_redirect_to_admin');


    /**
     * Remove unecessary widgets from dashboard
     *
     * @return void
     */
    function stori_remove_dashboard_widgets() {
        global $wp_meta_boxes;
     
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
     
    }
     
    add_action('wp_dashboard_setup', 'stori_remove_dashboard_widgets');

    /**
     * Remove all unecessary menus from admin
     *
     * @return void
     */
    function stori_admin_menu_remove() {
        remove_menu_page('index.php');                  // Dashboard
        remove_menu_page('jetpack');                    // Jetpack*
        remove_menu_page('edit.php');                   // Posts
        remove_menu_page('edit.php?post_type=page');    // Pages
        remove_menu_page('edit-comments.php');          // Comments
        remove_menu_page('tools.php');                  // Tools

        remove_submenu_page('themes.php', 'theme-editor.php');
        remove_submenu_page('plugins.php', 'plugin-editor.php');
        remove_submenu_page('options-general.php', 'options-discussion.php');
        remove_submenu_page('options-general.php', 'options-writing.php');
        remove_submenu_page('options-general.php', 'options-reading.php');
        remove_submenu_page('options-general.php', 'privacy.php');

        remove_submenu_page('edit.php?post_type=acf-field-group', 'acf-tools');
    }

    add_action('admin_menu', 'stori_admin_menu_remove');
    
    /**
     * Remove admin bar menu items
     *
     * @return void
     */
    function stori_admin_bar_menu_remove()  {
        global $wp_admin_bar;   
        $wp_admin_bar->remove_node('new-post');
        $wp_admin_bar->remove_node('new-link');
        $wp_admin_bar->remove_node('new-page');
    }

    add_action('admin_bar_menu', 'stori_admin_bar_menu_remove', 999);

    /**
     * Change default Login page to new branding
     *
     * @return void
     */
    function stori_login_enqueue_scripts() {
        wp_enqueue_style('stori-login', get_stylesheet_directory_uri() . '/css/login.css' );
    }

    add_action('login_enqueue_scripts', 'stori_login_enqueue_scripts');