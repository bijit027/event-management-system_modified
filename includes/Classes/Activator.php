<?php

namespace EMS\Classes;

if (!defined('ABSPATH')) {
    exit;
}


class Activator
{

    public function addVersion()
    {
        $is_installed = get_option('EMS_VERSION');
        if (!$is_installed) {
            update_option('EMS_VERSION', EMS_VERSION, false);
        }
        update_option('EMS_VERSION', EMS_VERSION, false);
      
    }


}