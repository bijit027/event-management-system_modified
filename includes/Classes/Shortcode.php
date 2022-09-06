<?php

namespace EMS\Classes;
/**
 * Shortcode handler class
 */
class Shortcode
{

    /**
     * Initializes the class
     */
    function __construct()
    {
        add_shortcode("event-management", [$this, "renderShortcode"]);
    }

    public function loadAssets()
    {
        wp_enqueue_style("ems_frontend_css", EMS_URL . "assets/frontend/css/frontend.css");
        wp_enqueue_script("ems_frontend_script", EMS_URL . "assets/frontend/js/ems_frontend.js",  ['jquery'], true);
        wp_enqueue_style("ems_frontend_bootstrap", EMS_URL . "assets/Bootstrap/bootstrap.min.css");
        wp_enqueue_script("ems_frontend_bootstrap_script", EMS_URL ."assets/Bootstrap/bootstrap.min1.js");
       
        
       

        wp_localize_script("ems_frontend_script", "ajax_url", [
            "ajaxurl" => admin_url("admin-ajax.php"),
            "ems_nonce" => wp_create_nonce("ems_ajax_nonce"),
        ]);
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function renderShortcode($atts = [], $content = "")
    {
        $atts = shortcode_atts(
            [
                "id" => "",
            ],
            $atts
        );
        $id = $atts["id"];

        if (!empty($atts["id"])) {

            return $this->renderAttributes();
        } else {

            return $this->renderAttributes();
        }
    }

    public function renderAttributes()
    {
        $this->loadAssets();
        //Load Shortcode View Page
        ob_start();
        include EMS_CONTACTS_PATH . "/includes/Views/AttributeRender.php";
        $content = ob_get_clean();
        return $content;
    }

}