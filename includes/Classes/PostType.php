<?php

namespace EMS\Includes\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register and initialize custom post type for plugin_name
 * @since 1.0.0
 */

class PostType
{
    public function __construct()
    {
        add_action('init', array($this, 'register'));
        // add_action( 'init', array( $this , 'custom_taxonomy') );
    }
    public function register()
    {
        $args = array(
            'capability_type' => 'post',
            'public'          => false,
            'show_ui'         => false,
        );
        register_post_type( 'ems_event_data', $args );
        // $RegistrationArgs = array(
        //     'capability_type' => 'post',
        //     'public'          => true,
        //     'show_ui'         => false,
        // );
        // register_post_type( 'ems_reg_data', $RegistrationArgs );

        register_taxonomy('eventCategory',array('ems_event_data'), array(
            'hierarchical' => true,
            'show_ui' => false,
        ));

        register_taxonomy('eventOrganizer',array('ems_event_data'), array(
            'hierarchical' => true,
            'show_ui' => false,

        ));

    }

}