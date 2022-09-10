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
            "title",  "onlineEvent", "category", "organizer",
            "startingDate", "startingTime", "endingDate", "endingTime",
            "location", "deadline"
        ];
        $field_keys = $this->handleEmptyField($value);
        $eventData = $this->senitizeInputValue($field_keys);

        if (!empty($_POST['data']['limit'])) {
            $limit = sanitize_text_field($_POST['data']['limit']);
            if (empty($limit)) {
                $this->sanitizationError('limit');
            } else {
                $eventData['limit'] = $limit;
            }
        }

        if (!empty($_POST['data']['details'])) {
            $details = sanitize_textarea_field($_POST['data']['details']);
            if (empty($details)) {
                $this->sanitizationError('details');
            } else {
                $eventData['details'] = $details;
            }
        }

        if (!empty($_POST['data']['url'])) {
            $url = sanitize_url($_POST['data']['url']);
            if (empty($url)) {
                $this->sanitizationError('url');
            } else {
                $eventData['url'] = $url;
            }
        }

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
        $value = ["title"];
        $field_keys = $this->handleEmptyField($value);
        $categoryData = $this->senitizeInputValue($field_keys);

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
        $registrationData = $this->senitizeInputValue($field_keys);
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
        $value = ["name", "details"];
        $field_keys = $this->handleEmptyField($value);
        $organizerData = $this->senitizeInputValue($field_keys);
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
        } else {
            return true;
        }
    }




    public function senitizeInputValue($field_keys)
    {
        $inputValue = $field_keys;
        $data = [];
        foreach ($inputValue as $field_key) {

            if (sanitize_text_field($_POST["data"][$field_key]) != '') {
                $data[$field_key] = $_POST["data"][$field_key];
            } else {
                $this->sanitizationError($field_key);
            }
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
                $field_key => __('Something suspicious in ' . $field_key, " event-management-system"),
            ],
            400
        );
    }
}
