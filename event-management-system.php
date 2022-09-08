<?php

/*
Plugin Name: Event Management System
Plugin URI: https://developer.wordpress.org/plugins/plugin-basics/header-requirements/
Description: This awesome plugin can helps you to manage your goals and activities!
Version: 1.121231.0
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
    define("EMS_CONTACTS_PATH", __DIR__);

    class EventManagementSystem
    {
        
        public function boot()
        {
            $this->textDomain();
            $this->loadDependecies();
            if (is_admin()) {
                $this->adminHooks();
            }
            $this->registerShortcodes();
        }

        public function adminHooks()
        {
            new \EMS\Classes\PostType();
            new \EMS\Classes\Models();
            //Register Admin menu
            $menu = new \EMS\Classes\Menu();
            $menu->register();

            // Top Level Ajax Handlers 
            $ajaxHandler = new \EMS\Classes\AdminAjaxHandler();
            $ajaxHandler->registerEndpoints();

            add_action('ems/render_admin_app', function () {
                $adminApp = new \EMS\Classes\AdminApp();
                $adminApp->bootView();
            });
        }

        public function textDomain()
        {
            load_plugin_textdomain('event-management-system', false, basename(dirname(__FILE__)) . '/languages');
        }

        public function loadDependecies(){
            require_once(EMS_DIR . 'includes/autoload.php');
        }

        public function registerShortcodes()
        {
            add_shortcode("event-management",  function (){

                $build =  new \EMS\Classes\Builder\Render();
                return $build->render();
            });  
        }
    }

    add_action('plugins_loaded', function () {
        (new EventManagementSystem())->boot();
    });
}

    register_activation_hook(__FILE__, function () {
        require_once(EMS_DIR . 'includes/Classes/Activator.php');
        $activator = new \EMS\Classes\Activator();
        $activator->addVersion(); 
    });