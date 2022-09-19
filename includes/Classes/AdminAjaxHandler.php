<?php

namespace EMS\Classes;

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
            'create_event'              => 'createEvent',
            'get_event_data'            => 'getEventData',
            'get_single_eventData'      => 'getSingleEventData',
            'delete_event'              => 'deleteEvent',
            'get_category_Data'         => 'getEventCategoryData',
            'add_event_category'        => 'insertEventCategoryData',
            'get_single_category_data'  => 'getSingleCategoryData',
            'delete_category'           => 'deleteCategory',
            'get_organizer_Data'        => 'getOrganizerData',
            'add_event_organizer'       => 'insertEventOrganizerData',
            'get_single_organizer_data' => 'getSingleOrganizerData',
            'delete_organizer'          => 'deleteOrganizer',
            'insert_registration_data'  => 'insertRegistrationData',
        );

        if (isset($validRoutes[$route])) {
            return $this->{$validRoutes[$route]}();
        }
    }

    public function createEvent()
    {
        $this->validateNonce();

        $value = [
            "title"         => 'sanitize_text_field',
            "onlineEvent"   => 'sanitize_text_field',
            "category"      => 'sanitize_text_field',
            "organizer"     => 'sanitize_text_field',
            'limit'         => 'sanitize_text_field',
            "startingDate"  => 'sanitize_text_field',
            "startingTime"  => 'sanitize_text_field',
            "endingDate"    => 'sanitize_text_field',
            "endingTime"    => 'sanitize_text_field',
            "location"      => 'sanitize_text_field',
            "deadline"      => 'sanitize_text_field'
        ];
        // $logo         = (isset($_POST['data']['image']) ? $_POST['data']['image'] : '');


        // $file = $_POST["data"]["image"];
        // var_dump($file);

        // $arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');

        // $upload = wp_upload_bits("abc/def", null,  $file);
        // var_dump($upload['url']);
        //$upload['url'] will gives you uploaded file path


        $this->handleEmptyField($value);
        $notRequiredValue = array("details" => "sanitize_textarea_field");
        $value = array_merge($value, $notRequiredValue);
        $eventData = $this->sanitizeInputValue($value);
        $eventData['image'] = (isset($_POST['data']['image']) ? $_POST['data']['image'] : '');
        if (isset($_POST["id"])) {
            $id = intval($_POST["id"]);
            parent::updateEventData($id, $eventData);
        } else {
            parent::addEventData($eventData);
        }
    }

    public function getEventData()
    {
        $this->validateNonce();
        parent::fetchEventData();
    }

    public function getSingleEventData()
    {
        $this->validateNonce();
        $id = intval($_GET["id"]);
        parent::fetchSingleEventData($id);
    }

    public function deleteEvent()
    {
        $this->validateNonce();
        $id = intval($_POST["id"]);
        $taxonomy = '';
        parent::deleteData($id, $taxonomy);
    }

    public function getEventCategoryData()
    {
        $this->validateNonce();
        $taxonomy = 'eventCategory';
        parent::fetchTermData($taxonomy);
    }

    public function insertEventCategoryData()
    {
        $this->validateNonce();
        $value = [
            "title" => "sanitize_text_field"
        ];
        $field_keys = $this->handleEmptyField($value);
        $categoryData = $this->sanitizeInputValue($field_keys);

        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            parent::updateCategoryData($id, $categoryData);
        } else {
            parent::addCategoryData($categoryData);
        }
    }

    public function getSingleCategoryData()
    {
        $this->validateNonce();
        $id = intval($_GET["id"]);
        parent::fetchSingleCategory($id);
    }

    public function getOrganizerData()
    {
        $this->validateNonce();
        $taxonomy = 'eventOrganizer';
        parent::fetchTermData($taxonomy);
    }

    public function getSingleOrganizerData()
    {
        $this->validateNonce();
        $id = intval($_GET["id"]);
        parent::getSingleOrganizer($id);
    }

    public function insertRegistrationData()
    {
        $this->validateNonce();
        $value = ["eventId", "eventTitle", "name", "email"];
        $field_keys = $this->handleEmptyField($value);
        $registrationData = $this->sanitizeInputValue($field_keys);
        parent::addRegistrationData($registrationData);
    }

    public function deleteCategory()
    {
        $this->validateNonce();
        $id = intval($_POST["id"]);
        $taxonomy = 'eventCategory';
        parent::deleteData($id, $taxonomy);
    }

    public function insertEventOrganizerData()
    {
        $this->validateNonce();
        $value = [
            "name" => "sanitize_text_field",
            "details" => "sanitize_textarea_field"
        ];
        $field_keys = $this->handleEmptyField($value);
        $organizerData = $this->sanitizeInputValue($field_keys);
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            parent::updateOrganizerData($id, $organizerData);
        } else {
            parent::addOrganizerData($organizerData);
        }
    }
    public function deleteOrganizer()
    {
        $this->validateNonce();
        $id = intval($_POST["id"]);
        $taxonomy = 'eventOrganizer';
        parent::deleteData($id, $taxonomy);
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
        }
        return true;
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
