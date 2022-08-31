export default class EMS {
    constructor() {
    //     this.applyFilters = applyFilters;
    //     this.addFilter = addFilter;
    //     this.addAction = addAction;
    //     this.doAction = doAction;
    //     this.Vue = Vue;
    //     this.Router = Router;
    }
    

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
        console.log(options);
        options.action = 'ems_events_admin_ajax';
        return window.jQuery.post(window.emsAdmin.ajaxurl, options);
    }


    $getJSON(options) {
        return window.jQuery.getJSON(window.wpPayFormsAdmin.ajaxurl, options);
    }
}
