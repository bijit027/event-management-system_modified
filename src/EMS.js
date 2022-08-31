export default class EMS {
    $get(options) {
        return window.jQuery.get(window.wpPayFormsAdmin.ajaxurl, options);
    }

    $adminGet(options) {
        options.action = 'wppayform_forms_admin_ajax';
        return window.jQuery.get(window.wpPayFormsAdmin.ajaxurl, options);
    }

    $post(options) {
        return window.jQuery.post(window.wpPayFormsAdmin.ajaxurl, options);
    }

    adminPost(options) {
        
        options.action = 'ems_events_admin_ajax';
        return window.jQuery.post(window.ajax_url.ajaxurl, options);
    }

    adminGet(options) {
        options.action = 'ems_events_admin_ajax';
        return window.jQuery.get(window.ajax_url.ajaxurl, options);
    }


    $getJSON(options) {
        return window.jQuery.getJSON(window.wpPayFormsAdmin.ajaxurl, options);
    }
}
