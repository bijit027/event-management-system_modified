<?php

namespace EMS\Includes\Classes;

class AdminAjaxHandler
{

    public function registerEndpoints()
    {
        add_action('wp_ajax_ems_events_admin_ajax', array($this, 'handleEndPoint'));
    }
    public function handleEndPoint()
    {
        $route = sanitize_text_field($_REQUEST['route']);

        $validRoutes = array(
            'get_data'    => 'getData',
            'create_event' => 'createEvent',
        );

        if (isset($validRoutes[$route])) {
            return $this->{$validRoutes[$route]}();
        }
        
   
    }

    protected function getData()
    {

    }
    protected function createEvent(){
        $title = $_POST['title'];

        wp_send_json_success($title);

    }

}