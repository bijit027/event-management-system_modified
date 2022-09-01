<?php

namespace EMS\Includes\Classes;

class Menu
{
    public function register()
    {
        add_action('admin_menu', array($this, 'addMenus'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueAssets'));
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
            array($this, 'render'),
            'dashicons-admin-site',
            25
        );

        $submenu['event-management-system.php']['my_profile'] = array(
            __('All Events', 'event-management-system'),
            $menuPermission,
            'admin.php?page=event-management-system.php#/',
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


    public function render() {
        do_action('ems/render_admin_app');
    }

    public function enqueueAssets()
    {
        if(isset($_GET['page']) && $_GET['page'] == 'event-management-system.php') {
            
        wp_enqueue_script(
            'ems_js',
            EMS_URL . 'assets/Admin/admin.js',
            array('jquery'),
            EMS_VERSION,
            true
        );
        wp_enqueue_style('ems_element_plus_css', EMS_URL . 'assets/ElementPlus/index.css');

        wp_localize_script("ems_js", "ajax_url", [
            "ajaxurl" => admin_url("admin-ajax.php"),
            "ems_nonce" => wp_create_nonce("ems_ajax_nonce"),
        ]);
    }
        
    }
}
