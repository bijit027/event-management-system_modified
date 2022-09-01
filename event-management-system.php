<?php

/*
Plugin Name: Event Management System
Plugin URI: https://developer.wordpress.org/plugins/plugin-basics/header-requirements/
Description: This awesome plugin can helps you to manage your goals and activities!
Version: 1.11.0
Author: Bijit
Author URI: Author URI: https://bijit.netlify.app/
License:GPL v2 or later
Text Domain: event-management-system
*/


/**
 * Event Management System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 *
 * Copyright 2022 Plugin Name LLC. All rights reserved.
 */

if (!defined('ABSPATH')) {
    exit;
}
if (!defined('EMS_VERSION')) {
    define('EMS_VERSION', '1.0.0');
    define('EMS_MAIN_FILE', __FILE__);
    define('EMS_URL', plugin_dir_url(__FILE__));
    define('EMS_DIR', plugin_dir_path(__FILE__));

    class EventManagementSystem
    {
        public function boot()
        {
            $this->textDomain();
            $this->loadDependecies();
            if (is_admin()) {
                $this->adminHooks();
            }
        }

        public function adminHooks()
        {

            new \EMS\Includes\Classes\PostType();
            new \EMS\Includes\Classes\Models();
            //Register Admin menu
            $menu = new \EMS\Includes\Classes\Menu();
            $menu->register();

            // Top Level Ajax Handlers 
            $ajaxHandler = new \EMS\Includes\Classes\AdminAjaxHandler();
            $ajaxHandler->registerEndpoints();

            add_action('ems/render_admin_app', function () {
                $adminApp = new \EMS\Includes\Classes\AdminApp();
                $adminApp->bootView();
            });
        }

        public function textDomain()
        {
            load_plugin_textdomain('event-management-system', false, basename(dirname(__FILE__)) . '/languages');
        }

        public function loadDependecies(){
            if (file_exists(__DIR__ . '/vendor/autoload.php')) {
                require_once __DIR__ . '/vendor/autoload.php';
            }
        }
    }

    add_action('plugins_loaded', function () {
        (new EventManagementSystem())->boot();
    });
}

    register_activation_hook(__FILE__, function () {
        require_once(EMS_DIR . 'includes/Classes/Activator.php');
        $activator = new \EMS\Includes\Classes\Activator();
        $activator->addVersion();
       
    });

    // disabled admin-notice on dashboard
//     add_action('admin_init', function () {
//         $disablePages = [
//             'event-management-system.php',
//         ];
//         if (isset($_GET['page']) && in_array($_GET['page'], $disablePages)) {
//             remove_all_actions('admin_notices');
//         }
//     } else {
//         add_action('admin_init', function () {
//             deactivate_plugins(plugin_basename(__FILE__));
//         });
//     });

// }