<?php

namespace EMS\Classes;

class Models
{
    public function addEventData($eventData)
    {
        $categoryId = (int)$eventData['category'];
        $term = get_term($eventData['category']);
        $eventData["category"] = $term->name;
        $eventData["categoryID"] = $categoryId;

        $finalData = json_encode($eventData);
        $metaArray = array(
            "eventData" =>  $finalData,
        );

        $data = array(
            'post_title'    =>  $eventData['title'],
            'post_type'     =>  'ems_event_data',
            'meta_input'    =>  $metaArray,
            'post_status'   =>  'publish',
        );
        $eventId =  wp_insert_post($data, true);
        if (is_wp_error($eventId)) {
            // $errorMessage = $eventId->get_error_message();
            // $errorCode = $eventId->get_error_code();
            // var_dump($errorMessage);
            // var_dump($errorCode);
            // return wp_send_json_error(
            //     [
            //         "error" => __($errorMessage, " event-management-system"),
            //     ],
            //     $errorCode
            // );
            return wp_send_json_error(
                [
                    "error" => __("Error while inserting data", " event-management-system"),
                ],
                500
            );
        }
        wp_set_object_terms($eventId, [$categoryId], 'eventCategory');
        return wp_send_json_success(
            [
                "message" => __("Successfully inserted data", " event-management-system"),
            ],
            200
        );
    }

    public function fetchEventData()
    {
        $args = array(
            'numberposts' => -1,
            'orderby' => 'date',
            'order' => 'ASC',
            'post_type' => 'ems_event_data',
            'post_status' => 'publish',
        );
        $data = get_posts($args);
        if (!$data) {
            return wp_send_json_error(
                [
                    "error" => __("No events were created yet ", " event-management-system"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                'event_data'     => $data,
            ],
            200
        );
    }

    public function fetchEventDataForUser($eventCategory, $orderBy, $order, $paged)
    {

        $eventsId =  get_objects_in_term($eventCategory, 'eventCategory');
        if (empty($eventsId) && !empty($eventCategory)) {
            return wp_send_json_error(
                [
                    "error" => __("No events were found for this category", " event-management-system"),
                ],
                500
            );
        }



        // $args = array(
        //     'numberposts' => 4,
        //     'orderby' => $orderBy,
        //     'order' => $order,
        //     'paged' => $paged,
        //     'post_type' => 'ems_event_data',
        //     'post_status' => 'publish',

        //     'tax_query' => array(
        //         array(
        //             'taxonomy' => 'eventCategory',
        //             'terms' => $eventCategory,
        //         ),
        //     ),
        //     // 'category__and' => $eventCategory

        // );
        // $data = WP_Query($args);


        $args = array(
            'numberposts' => 4,
            'orderby' => $orderBy,
            'order' => $order,
            'paged' => $paged,
            'post_type' => 'ems_event_data',
            'post_status' => 'publish',
            'include'   => $eventsId,
            // 'category__and' => $eventCategory

        );
        $data = get_posts($args);
        //Bind post_meta_data with post_data
        foreach ($data as $value) {
            $meta = get_post_meta($value->ID, '', true);
            if ($meta) {
                $value->meta_value = $meta['eventData'];
            } else {
                $value->meta_value = null;
            }
        }

        // $data["totalPosts"] = wp_count_posts('ems_event_data')->publish;
        $totalPosts = wp_count_posts('ems_event_data')->publish;

        if (!$data) {
            return wp_send_json_error(
                [
                    "error" => __("No events were created yet ", " event-management-system"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                'event_data'    => $data,
                'total_posts'   => $totalPosts
            ],
            200
        );
    }

    public function fetchSingleEventData($id)
    {
        $singleEvent = get_post_meta($id, '', true);
        if (!$singleEvent) {

            return wp_send_json_error(
                [
                    "error" => __("Error while fetching data", " event-management-system"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                'single_event_data'     => $singleEvent,
            ],
            200
        );
    }

    public function addOrganizerData($organizerData)
    {
        extract($organizerData); //extract $name and $details
        $id =  wp_insert_term($name, 'eventOrganizer', array(
            "description" => $details
        ));

        if (is_wp_error($id)) {
            return wp_send_json_error(
                [
                    "error" => __("Error while inserting data", " event-management-system"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                "message" => __("Successfully inserted data", " event-management-system"),
            ],
            200
        );
    }

    public function updateOrganizerData($id, $organizerData)
    {
        extract($organizerData); //It will extract $name , $details
        $formId = wp_update_term($id, 'eventOrganizer', array(
            "name"         => $name,
            "slug"         => $name,
            "description"  => $details

        ));
        if (is_wp_error($formId)) {
            return wp_send_json_error(
                [
                    "error" => __("Error while editing data", " event-management-system"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                "message" => __("Successfully edited data", " event-management-system"),
            ],
            200
        );
    }

    public function updateEventData($id, $eventData)
    {
        // var_dump($eventData['image']);
        $categoryId = (int)$eventData['category'];
        $term = get_term($eventData['category']);
        $eventData["category"] = $term->name;
        $eventData["categoryID"] = $categoryId;
        $postContent = json_encode($eventData);
        extract($eventData); //Extract $id, $title , $postContent, $metaArray
        $metaArray = array(
            'eventData' =>  $postContent,
        );
        $data = array(
            'ID' => $id,
            'post_title'     => $title,
            'meta_input' => $metaArray,
        );

        $eventId =  wp_update_post($data, true);
        if (is_wp_error($eventId)) {
            return wp_send_json_error(
                [
                    "error" => __("Error while updating data", "event-management-system"),
                ],
                500
            );
        }

        wp_set_object_terms($eventId, [$categoryId], 'eventCategory');

        return wp_send_json_success(
            [
                "message" => __("Successfully updated Data", "event-management-system"),
            ],
            200
        );
    }

    public function addCategoryData($categoryData)
    {
        extract($categoryData); //It will extract $title
        $id = wp_insert_term($title, 'eventCategory');
        if (is_wp_error($id)) {
            return wp_send_json_error(
                [
                    "error" => __("Error while inserting data", " event-management-system"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                "message" => __("Successfully inserted data", " event-management-system"),
            ],
            200
        );
    }

    public function getSingleOrganizer($id)
    {
        $data = get_term($id);
        if (is_wp_error($data)) {
            return wp_send_json_error(
                [
                    "error" => __("Error while fetching data", " event-management-system"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                'single_organizer_data' => $data,
            ],
            200
        );
    }

    public function updateCategoryData($id, $categoryData)
    {
        extract($categoryData);
        $termID = wp_update_term($id, 'eventCategory', array(
            "name" => $title,
            "slug" => $title,
        ));
        if (is_wp_error($termID)) {
            return wp_send_json_error(
                [
                    "error" => __("Error while updating data", "event-management-system"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                "message" => __("Successfully Edited Data", "event-management-system"),
            ],
            200
        );
    }

    public function fetchSingleCategory($id)
    {
        $data = get_term($id);
        if (is_wp_error($data)) {
            return wp_send_json_error(
                [
                    "error" => __("Error while fetching data", "event-management-system"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                'single_category_data'     => $data,
            ],
            200
        );
    }


    public function fetchTermData($taxonomy)
    {

        $data = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ));
        if (is_wp_error($data)) {
            return wp_send_json_error(
                [
                    "error" => __("Error while fetching data", "event-management-system"),
                ],
                500
            );
        } else {
            return wp_send_json_success(
                [
                    'term_data'     => $data,
                ],
                200
            );
        }
    }

    public function deleteData($id, $taxonomy)
    {

        if ($taxonomy == "") {
            $delete = wp_delete_post($id);
        } else {
            $delete = wp_delete_term($id, $taxonomy);
        }
        if (!$delete) {
            return wp_send_json_error(
                [
                    "error" => __("Error while deleting data", "event-management-system"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                "message" => __("Successfully deleted data", "contact-manager"),
            ],
            200
        );
    }

    public function addRegistrationData($registrationData)
    {
        extract($registrationData); //It will extract $eventId, $eventTitle, $name, $email

        $postData = $this->fetchRegistrationData();

        $authenticatedEmail = $this->emailAuthentication($postData, $email, $eventId);

        if ($authenticatedEmail == true) {

            $this->updateAvailableRegistration($singleEvent, $eventId);

            $finalData = json_encode($registrationData);


            $metaArray = array(
                'registrationData' =>  $finalData,
            );

            $data = array(
                'post_title'    =>  $name,
                'post_type'     =>  'ems_reg_data',
                'meta_input'    =>  $metaArray,
            );

            $formId =  wp_insert_post($data, true);

            if (is_wp_error($formId)) {
                return wp_send_json_error(
                    [
                        "error" => __("Error while inserting data", " event-management-system"),
                    ],
                    500
                );
            }
            return wp_send_json_success(
                [
                    "message" => __("Registration Successful", " event-management-system"),
                ],
                200
            );
        }
        return wp_send_json_error(
            [
                "email" => __("Already registered by this email", " event-management-system"),
            ],
            500
        );
    }

    public function updateAvailableRegistration($singleEvent, $eventId)
    {
        $singleEvent = get_post_meta($eventId, '', true);
        $previousData = json_decode($singleEvent["eventData"][0]);
        $previousData->limit = $previousData->limit - 1;
        $updatedMetaDataLimit = json_encode($previousData);
        update_post_meta($eventId, "eventData", $updatedMetaDataLimit);
    }

    public function emailAuthentication($postData, $email, $eventId)
    {

        foreach ($postData as $value) {
            $metaData = get_post_meta($value->ID, '', true);
            $registeredData = json_decode($metaData["registrationData"][0]);
            if ($registeredData->email == $email && $registeredData->eventId == $eventId) {
                return false;
                die();
            }
        }
        return true;
    }

    public function fetchRegistrationData()
    {
        $args = array(
            'numberposts' => -1,
            'orderby' => 'date',
            'order' => 'ASC',
            'post_type' => 'ems_reg_data',
            'post_status' => 'any',
        );
        $data =  get_posts($args);
        if (is_wp_error($data)) {
            return false;
        }
        return $data;
    }

    public function fetchSingleRegistrationData($id)
    {
        $singleEvent = get_post_meta($id);
        if (!$singleEvent) {
            return wp_send_json_error(
                [
                    "error" => __("Error while fetching data", " event-management-system"),
                ],
                500
            );
            return wp_send_json_success($singleEvent, 200);
        }
        return wp_send_json_success($singleEvent, 200);
    }
}
