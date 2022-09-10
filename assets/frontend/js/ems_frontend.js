;


(function ($) {

    $(document).ready(function () {

        // let emsClose = '.ems_register_close';

        // $(emsClose).on('click', )

        // var that = this;
        // var category = [];
        // $.get(ajax_url.ajaxurl, {
        //     ems_nonce: ajax_url.ems_nonce,
        //     action: 'ems_events_user_ajax',
        //     route: 'get_category_Data',
        // }, function (data) {
        //     that.category = data.data.term_data;
        //     fetchEventData();
        //     var html = '';
        //     $.each(that.category, function (index, value) {
        //         html += `<option value="${value.term_id}">${value.name}</option>`;
        //     })
        //     $(".ems_category").append(html);
        // }
        // );
        fetchEventData();
        var eventCategory = "";
        var orderBy = "";
        var order = "";

        $(".ems_category,.ems_orderBy,.ems_order").each(function () {
            $(this).on("change", function () {
                this.orderBy = $(".ems_orderBy").val();
                this.eventCategory = $(".ems_category").val();
                this.order = $(".ems_order").val();
                $(".ems_category_error").empty();
                fetchEventData(this.eventCategory, this.orderBy, this.order);
            });
        })

        var events = [];
        var that = this;
        function fetchEventData(eventCategory = "", orderBy = "", order = "") {
            $.get(ajax_url.ajaxurl, {

                action: 'ems_events_user_ajax',
                route: 'get_data_for_user',
                category: eventCategory,
                orderBy: orderBy,
                order: order,
                ems_nonce: ajax_url.ems_nonce,
            }, function (data) {

                events = data.data.event_data;
                console.log(events);
                renderEventCards(events);
            }).fail(function (error) {
                $(".ems_row").empty();
                $(".ems_category_error").text(error.responseJSON.data.error).css("color", "red");
            });

        }

        async function renderEventCards(events) {
            var html = '';
            $(".card-content").html('');
            var url = window.location.href;

            $.each(events, function (index, value) {



                var Id = value.ID;
                var title = value.post_title;
                var content = JSON.parse(value.meta_value);

                console.log(content.limit);

                if (content.limit > 0) {
                    html += `<div class="col-sm-4">`;
                    html += `<div class="card">`;
                    html += `<div class="card-image"><img class="" src="${content.url}" alt=""></div>`;
                    html += `<div class="card-body card-info">`;
                    html += `<div class="card-text event_id">${Id}</div>`;
                    html += `<div class="card-text event_title"><b> ${title} </b></div>`;
                    html += `<div class="card-text ems_startingDate"><small><i class="fa fa-calendar" aria-hidden="true"></i> ${content.startingDate}</small></div>`;
                    html += `<div class="card-text ems_location"><small><i class="fas fa-map-marker-alt"></i> ${content.location}</small></div>`;

                    html += `<div><button type="button" class="btn btn-primary float-right btn-sm  viewEvent">View</button></div>`
                    html += `</div>`;
                    html += `</div>`;
                    html += `</div>`;
                }
            });
            $(".row").append(html);

        }

        //View Event
        $(document).on("click", ".viewEvent", function () {
            var id = $(this).closest('.card').find('.event_id').text();
            var singleEvent = {};

            const that = this;
            $.get(ajax_url.ajaxurl, {
                action: "ems_events_user_ajax",
                route: "get_single_eventData",
                id: id,
                ems_nonce: ajax_url.ems_nonce,
            },
                function (data) {
                    that.singleEvent = data.data.single_event_data;
                    var value = JSON.parse(that.singleEvent.eventData);
                    var html = '';

                    html += `<div class="wrap">`;
                    html += `<div class="image"><img src="${value.url}" alt="" width="800" height="800"></div>`;
                    html += `<div class="details">`;
                    html += `<div id="${id}" class="event_id"><b>ID:</b> ${id}</div>`;
                    html += `<div title="${value.title}" class="ems_title"><b> ${value.title}</b></div>`;
                    html += `<div class="ems_event_details">`
                    html += `<div><b>Category:</b> ${value.category}</div>`;
                    html += `<div><b>Details:</b> ${value.details}</div>`;
                    html += `<div><b>Starting Date:</b> ${value.startingDate}</div>`;
                    html += `<div><b>Starting Time:</b> ${value.startingTime}</div>`;
                    html += `<div><b>Ending Date:</b> ${value.endingDate}</div>`;
                    html += `<div><b>Ending Time:</b> ${value.endingTime}</div>`;
                    html += `<div><b>Organizer:</b> ${value.organizer}</div>`;
                    html += `<div><b>Limit:</b> ${value.limit}</div>`;
                    html += `<div><b>Location:</b> ${value.location}</div>`;
                    html += `<div><b>Online Event:</b> ${value.onlineEvent}</div>`;
                    html += `</div>`
                    html += `<div class="button"><button type="button" class="btn btn-primary  float-right registerEvent">Register</button></div>`

                    html += `</div>`;
                    html += `</div>`;
                    $("#ems_event_view").modal("show");
                    $("#ems_event_data").html(html).show();

                }).fail(function (error) {
                    alert(error.responseJSON.data.error);
                });
        });

        $(document).on("click", ".registerEvent", function (e) {
            e.preventDefault();

            $('#ems_event_view').modal('hide');
            $("#ems_registration_view").modal("show");
        });


        $('#ems_registration_form').on('submit', function (e) {
            e.preventDefault();
            var user = {};

            user.eventId = $(".registerEvent").closest('.wrap').find('.event_id').attr('id');
            user.eventTitle = $(".registerEvent").closest('.wrap').find('.ems_title').attr('title');

            $(".ems_event_title").text(user.eventTitle);
            user.name = $('input[name="name"]').val();
            user.email = $('input[name="email"]').val();
            handleRegisterEvent(user)

        });


        $(document).on("click", ".ems_register_close", handleModelClose)

    });

    function handleRegisterEvent(user) {

        $.post(ajax_url.ajaxurl, {
            action: 'ems_events_user_ajax',
            route: "insert_registration_data",
            data: user,
            ems_nonce: ajax_url.ems_nonce,
        },
            function (data) {
                // $('input[name="name"]').val("");
                // $('input[name="email"]').val("");
                $('#ems_success').html(data.data.message).fadeIn('slow').css("color", "green");
                handleModelClose();
                // $("#ems_registration_form").trigger("reset");
                // $('.ems_name_error').hide();
                // $('.ems_email_error').hide();

            }).fail(function (error) {
                // $('input[name="name"]').val("");
                // $('input[name="email"]').val("");
                $('#ems_error').html(error.responseJSON.data.error).fadeIn('slow').css("color", "red");
                $('#ems_success').hide();
                $('.ems_name_error').hide();
                $('.ems_email_error').hide();
                if (error.responseJSON.data.name != "" && error.responseJSON.data.email != "") {
                    $('.ems_name_error').html(error.responseJSON.data.name).fadeIn('slow');
                    $('.ems_email_error').html(error.responseJSON.data.email).fadeIn('slow');
                } else {
                    if (error.responseJSON.data.name != "") {
                        $('.ems_name_error').html(error.responseJSON.data.name).fadeIn('slow');
                    } else {
                        $('.ems_email_error').html(error.responseJSON.data.email).fadeIn('slow');
                    }
                }
                // if (error.responseJSON.data.email != "") {

                //     $('.ems_email_error').html(error.responseJSON.data.email).fadeIn('slow');

                // }
            })

    }

    function handleModelClose(event) {
        event.preventDefault();
        $('.ems_name_error').hide();
        $('.ems_email_error').hide();
        $('#ems_success').hide()
    }


})(jQuery);