<?php

namespace EMS\Classes;

if (!defined('ABSPATH')) {
    exit;
}


class AdminApp
{
    public function bootView()
    {
        echo "<div id='ems-admin-app'></div>";
    }
}