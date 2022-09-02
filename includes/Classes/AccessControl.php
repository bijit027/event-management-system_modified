<?php


namespace EMS\Classes;

class AccessControl
{
    public static function hasTopLevelMenuPermission()
    {
        $menuPermissions = array(          
            'manage_options',
            'delete_users',
            'edit_users',
        );
        foreach ($menuPermissions as $menuPermission) {
            if (current_user_can($menuPermission)) {
                return $menuPermission;
            }
            else{
                return false;
            }
        }

    }
}