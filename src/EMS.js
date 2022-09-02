export default class EMS {

    adminPost(options) {
        options.action = 'ems_events_admin_ajax';
        return window.jQuery.post(window.ajax_url.ajaxurl, options);
    }

    adminGet(options) {
        options.action = 'ems_events_admin_ajax';
        return window.jQuery.get(window.ajax_url.ajaxurl, options);
    }
}
