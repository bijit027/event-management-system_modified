<?php

namespace EMS\Includes\Classes;

class Menu
{
    public function register()
    {
        add_action('admin_menu', array($this, 'addMenus'));
    }

    public function addMenus()
    {
        $menuPermission = AccessControl::hasTopLevelMenuPermission();
        if (!$menuPermission) {
            return;
        }

        $title = __('Event Management System', 'event-management-system');
        global $submenu;
        add_menu_page(
            $title,
            $title,
            $menuPermission,
            'event-management-system.php',
            array($this, 'enqueueAssets'),
            'dashicons-admin-site',
            25
        );

        $submenu['event-management-system.php']['my_profile'] = array(
            __('All Events', 'event-management-system'),
            $menuPermission,
            'admin.php?page=event-management-system.php#/',
        );
        $submenu['event-management-system.php']['add_event'] = array(
            __('Add Event', 'event-management-system'),
            $menuPermission,
            'admin.php?page=event-management-system.php#/addevent',
        );
        $submenu['event-management-system.php']['categories'] = array(
            __('Categories', 'event-management-system'),
            $menuPermission,
            'admin.php?page=event-management-system.php#/categories',
        );
        $submenu['event-management-system.php']['organizers'] = array(
            __('Organizers', 'event-management-system'),
            $menuPermission,
            'admin.php?page=event-management-system.php#/organizers',
        );
    }

    public function enqueueAssets()
    {
        do_action('event-management-system/render_admin_app');

        wp_enqueue_script(
            'ems_js',
            ems_URL . 'assets/Admin/admin.js',
            array('jquery'),
            ems_VERSION,
            true
        );
        wp_enqueue_style('ems_admin_css', ems_URL . 'assets/ElementPlus/index.css');
       

        $PluginNameAdminVars = apply_filters('event-management-system/admin_app_vars', array(
            'assets_url' => ems_URL . 'assets/',
            'ajaxurl' => admin_url('admin-ajax.php'),
            "ems_nonce" => wp_create_nonce("ems_ajax_nonce"),
        ));

        wp_localize_script("ems_js", "emsAdmin", [
            "ajaxurl" => admin_url("admin-ajax.php"),
            "ems_frontend_nonce" => wp_create_nonce("ems_ajax_frontend_nonce"),
        ]);

        // wp_localize_script('ems_js', 'emsAdmin', $PluginNameAdminVars);
    }
}
