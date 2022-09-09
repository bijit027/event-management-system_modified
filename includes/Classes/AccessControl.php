<?php


namespace EMS\Classes;

class AccessControl
{
    public static function hasTopLevelMenuPermission()
    {
        $menuPermissions = array(
            'manage_options',
        );
        foreach ($menuPermissions as $menuPermission) {
            if (current_user_can($menuPermission)) {
                return $menuPermission;
            } else {
                return false;
            }
        }
    }
}
