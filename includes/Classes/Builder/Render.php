<?php

namespace EMS\Classes\Builder;
/**
 * Shortcode handler class
 */
class Render
{

    public function loadAssets()
    {
        wp_enqueue_style("ems_frontend_css", EMS_URL . "assets/frontend/css/frontend.css");
        wp_enqueue_script("ems_frontend_script", EMS_URL . "assets/frontend/js/ems_frontend.js",  ['jquery'], true);
        wp_enqueue_style("ems_frontend_bootstrap", EMS_URL . "assets/bootstrap/bootstrap.min.css");
        wp_enqueue_script("ems_frontend_bootstrap_script", EMS_URL ."assets/bootstrap/bootstrap.min.js");

        wp_localize_script("ems_frontend_script", "ajax_url", [
            "ajaxurl" => admin_url("admin-ajax.php"),
            "ems_nonce" => wp_create_nonce("ems_ajax_nonce"),
        ]);
    }

    public function render()
    {
        $this->loadAssets();
        //Load Shortcode View Page
        ob_start();
        include EMS_CONTACTS_PATH . "/includes/views/attributeRender.php";
        $content = ob_get_clean();
        return $content;
    }

}