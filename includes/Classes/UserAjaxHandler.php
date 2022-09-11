<?php

namespace EMS\Classes;

class UserAjaxHandler extends Models
{
    public function registerEndpoints()
    {
        if (is_user_logged_in()) {
            add_action('wp_ajax_ems_events_user_ajax', array($this, 'handleEndPoint'));
        }
        add_action('wp_ajax_nopriv_ems_events_user_ajax', array($this, 'handleEndPoint'));
    }
    public function handleEndPoint()
    {
        $route = sanitize_text_field($_REQUEST['route']);

        $validRoutes = array(
            'get_event_data'            => 'getEventData',
            'get_single_eventData'      => 'getSingleEventData',
            'get_data_for_user'         => 'getDataForUser',
            'insert_registration_data'  => 'insertRegistrationData',
            'get_category_Data'         => 'getEventCategoryData',
            'delete_organizer'          => 'deleteOrganizer',
        );

        if (isset($validRoutes[$route])) {
            return $this->{$validRoutes[$route]}();
        }
    }

    public function getEventData()
    {
        $this->validateNonce();
        parent::fetchEventData();
    }

    public function getDataForUser()
    {
        $eventCategory = '';
        $orderBy =  '';
        $order = '';
        $this->validateNonce();

        if (!empty($_GET['category'])) {
            $eventCategory = sanitize_text_field($_GET['category']);
        }
        if (!empty($_GET['orderBy'])) {
            $orderBy = sanitize_text_field($_GET['orderBy']);
        }
        if (!empty($_GET['order'])) {
            $order = sanitize_text_field($_GET['order']);
        }
        parent::fetchEventDataForUser((int)$eventCategory, $orderBy, $order);
    }

    public function getSingleEventData()
    {
        $this->validateNonce();
        $id = intval($_GET["id"]);
        parent::fetchSingleEventData($id);
    }

    public function getEventCategoryData()
    {
        $this->validateNonce();
        $taxonomy = 'eventCategory';
        parent::fetchTermData($taxonomy);
    }

    public function insertRegistrationData()
    {
        $this->validateNonce();
        $value = [
            "eventId"    => "sanitize_text_field",
            "eventTitle" => "sanitize_text_field",
            "name"       => "sanitize_text_field",
            "email"      => "sanitize_email"
        ];
        $this->handleEmptyField($value);
        $registrationData = $this->sanitizeInputValue($value);
        parent::addRegistrationData($registrationData);
    }

    public function validateNonce()
    {
        $value  = $_REQUEST["ems_nonce"];
        if (!wp_verify_nonce($value, "ems_ajax_nonce")) {
            return wp_send_json_error(
                [
                    "error" => __("Busted! Please login!", "event-management-system"),
                ],
                400
            );
        } else {
            return true;
        }
    }

    public function sanitizeInputValue($field_keys)
    {
        $data = [];
        $error = [];
        foreach ($field_keys as $key => $sanitizer) {
            $data[$key] = call_user_func($sanitizer, $_POST["data"][$key]);
            if (!$data[$key]) {
                $error[$key] = $key;
            }
        }
        if ($error) {
            $this->sanitizationError($error);
        }
        return $data;
    }

    public function handleEmptyField($value)
    {
        $errors = [];
        foreach ($value as $field_key => $sanitizer) {
            if (empty($_POST["data"][$field_key])) {
                $errors[$field_key] = "Please enter " . $field_key;
            }
        }
        if (!empty($errors)) {
            return wp_send_json_error($errors, 400);
        }
        return $value;
    }

    public function sanitizationError($field_key)
    {
        $errors = [];
        foreach ($field_key as $key => $value) {
            $errors[$key] = 'Invalid data type for ' . $key;
        }
        if ($errors) {
            return wp_send_json_error($errors, 400);
        }
    }
}
