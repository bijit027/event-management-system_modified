<?php

namespace EMS\Includes\Classes;

class AdminAjaxHandler extends Models
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
            'get_eventData' => 'getEventData',
            'get_single_eventData' => 'getSingleEventData',
            'delete_event' => 'deleteEvent'
        );

        if (isset($validRoutes[$route])) {
            return $this->{$validRoutes[$route]}();
        }
        
   
    }

    protected function getData()
    {

    }
    protected function createEvent()
    {
        // if (!wp_verify_nonce($_POST["ems_nonce"], "ems_ajax_nonce")) {
        //     return wp_send_json_error("Busted! Please login!", 400);
        // }

        // $value = $_POST["data"];

        // extract($value);
        // wp_send_json_success($value['title']);
        if (!wp_verify_nonce($_POST['ems_nonce'], 'ems_ajax_nonce')) {
            return wp_send_json_error('Busted! Please login!', 400);
          }

        $value = ["title",  "onlineEvent",
                 "startingDate","startingTime","endingDate","endingTime",
                "location","deadline"];
        $field_keys = $this->handleEmptyField($value);
        // array_push($field_keys,"category","organizer");
        $eventData = $this->senitizeInputValue($field_keys);

        if (!empty($_POST['data']['limit'])) {
            $limit = sanitize_text_field($_POST['data']['limit']);
            if(empty($limit)){
                $this->sanitizationError('limit');
            }else{
            $eventData['limit'] = $limit;
            }
          }

        if (!empty($_POST['data']['details'])) {
            $details = sanitize_textarea_field($_POST['data']['details']);
            if(empty($details)){
                $this->sanitizationError('details');
            }
            else{
            $eventData['details'] = $details;
            }
        }

        if (!empty($_POST['data']['url'])) {
            $url = sanitize_url($_POST['data']['url']);
            if(empty($url)){
                $this->sanitizationError('url');
            }
            else{
                $eventData['url'] = $url;
            }
            
        }

        // var_dump($eventData);

       
        // wp_send_json_success($eventData);
        if (isset($_POST["id"])) {
            $id = intval($_POST["id"]);
            parent::updateEventData($id, $eventData);
        } else {
            parent::addEventData($eventData);
        }


    }
    protected function getEventData(){
        if (!wp_verify_nonce($_GET['ems_nonce'], 'ems_ajax_nonce')) {
            return wp_send_json_error('Busted! Please login!', 400);
          }
        parent::fetchEventData();
    }

    protected function getSingleEventData()
    {
        if (!wp_verify_nonce($_GET['ems_nonce'], 'ems_ajax_nonce')) {
            return wp_send_json_error('Busted! Please login!', 400);
          }
        $id = intval($_GET["id"]);
      
       
        parent::fetchSingleEventData($id);
    }

    protected function deleteEvent(){
        if (!wp_verify_nonce($_POST['ems_nonce'], 'ems_ajax_nonce')) {
            return wp_send_json_error('Busted! Please login!', 400);
          }
        $id = intval($_POST["id"]);
        parent::deleteEventData($id);
    }

    public function senitizeInputValue($field_keys)
    {
        $inputValue = $field_keys;
        $data = [];
        foreach ($inputValue as $field_key) {
            // if($field_key == 'details'){
            //     if(sanitize_textarea_field($_POST['data'][$field_key]) != '' ){
            //     $data[$field_key] = sanitize_textarea_field($_POST["data"][$field_key]);
            //     }else{
            //         $this->sanitizationError($field_key);
            //     }
            // }
            // if($field_key == 'url'){
            //     if(sanitize_url($_POST["data"][$field_key]) != '' ){
            //         $data[$field_key] = sanitize_url($_POST["data"][$field_key]);
            //     }else{
            //         $this->sanitizationError($field_key);
            //     }
            // }
            // else{
                if(sanitize_text_field($_POST["data"][$field_key]) != '' ){
                    $data[$field_key] = $_POST["data"][$field_key];
                }else{
                    $this->sanitizationError($field_key);
                }
            // }
        }
        
        return $data;
    }

    public function handleEmptyField($value)
    {
        $inputValue = $value;
        $errors = [];
        foreach ($inputValue as $field_key) {
            if (empty($_POST["data"][$field_key])) {
                $errors[$field_key] = "Please enter " . $field_key;
            }
        }
        if (!empty($errors)) {
            return wp_send_json_error($errors, 400);
        }
        return $inputValue;
    }

    public function sanitizationError($field_key)
    {
        
        return wp_send_json_error(
            [
                $field_key => __('Something suspicious in '.$field_key, " event-management-system"),
            ],
            400);
    }

}