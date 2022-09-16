; (function ($) {

    $(document).ready(function () {

        fetchEventData();
        $(".ems_category,.ems_orderBy,.ems_order").each(function () {
            let eventCategory = "";
            let orderBy = "";
            let order = "";
            $(this).on("change", function () {
                this.orderBy = $(".ems_orderBy").val();
                this.eventCategory = $(".ems_category").val();
                this.order = $(".ems_order").val();
                $(".ems_event_error").empty();
                fetchEventData(this.eventCategory, this.orderBy, this.order);
            });
        })

        //View Event
        $(document).on("click", ".viewEvent", viewEvent)

        $(document).on("click", ".registerEvent", function (e) {
            e.preventDefault();
            let eventtitle = $(".registerEvent").closest('.wrap').find('.ems_title').attr('title');
            $(".ems_event_title").text(eventtitle);
            $('#ems_event_view').modal('hide');
            $("#ems_registration_view").modal("show");
        });


        $('#ems_registration_form').on('submit', function (e) {
            e.preventDefault();
            let user = {};

            // user.eventId = $(".registerEvent").closest('.wrap').find('.event_id').attr('id');
            // user.eventTitle = $(".registerEvent").closest('.wrap').find('.ems_title').attr('title');
            user.eventId = $('.wrap').find('.event_id').attr('id');
            user.eventTitle = $('.wrap').find('.ems_title').attr('title');


            user.name = $('input[name="name"]').val();
            user.email = $('input[name="email"]').val();
            handleRegisterEvent(user)

        });


        // $(document).on("click", ".ems_register_close", function () {
        $(document).on("click", ".close", function () {
            $("#ems_registration_form").trigger("reset");
            handleModelMessage();
        });

        $(document).on('click', '.paginate', function () {
            pageno = $(this).attr('ems_page_no');
            orderBy = $(".ems_orderBy").val();
            eventCategory = $(".ems_category").val();
            order = $(".ems_order").val();
            // pageno = 1;
            fetchEventData(eventCategory, orderBy, order, pageno);
            // renderRequest(pageno);

        });

        function fetchEventData(eventCategory = "", orderBy = "", order = "", pageno = "") {
            $.get(ajax_url.ajaxurl, {
                action: 'ems_events_user_ajax',
                route: 'get_data_for_user',
                category: eventCategory,
                orderBy: orderBy,
                order: order,
                paged: pageno,
                ems_nonce: ajax_url.ems_nonce,
            }, function (data) {
                events = data.data.event_data;
                totalPosts = data.data.total_posts;
                $(".ems_row").empty();
                $(".ems_filter").css("display", "block");
                renderEventCards(events, totalPosts);

            }).fail(function (error) {
                $(".ems_row").empty();
                $(".ems_event_error").text(error.responseJSON.data.error).css("color", "red");
            });

        }

        async function renderEventCards(events, totalPosts) {
            let reqPerPage = 4;
            let totalPages = Math.ceil(totalPosts / reqPerPage);
            let html = '';
            $(".card-content").html('');
            let url = window.location.href;

            $.each(events, function (index, value) {
                let Id = value.ID;
                let title = value.post_title;
                let content = JSON.parse(value.meta_value);

                if (content.limit > 0) {

                    html += `<div class="col-sm-3 ems_more_card">`;
                    html += `<div class="card" style="cursor: pointer;">`;
                    html += `<div class="card-image"><img class="" src="${content.image}" alt=""></div>`;
                    html += `<div class="card-body card-info">`;
                    html += `<div class="card-text event_id">${Id}</div>`;
                    html += `<div class="card-text event_title stretched-link viewEvent"><b> ${title} </b></div>`;
                    html += `<div class="card-text ems_startingDate"><small><i class="fa fa-calendar" aria-hidden="true"></i> ${content.startingDate}</small></div>`;
                    html += `<div class="card-text ems_card_location"><small><i class="fas fa-map-marker-alt"></i> ${content.location}</small></div>`;

                    // html += `<div><button type="button" class="btn btn-primary float-right btn-sm stretched-link viewEvent">View</button></div>`
                    html += `</div>`;
                    html += `</div>`;
                    html += `</div>`;

                }
            });
            html += `<div class="pagination">`;
            for (i = 1; i <= totalPages; i++) {
                html += `<a class="paginate" ems_page_no = ${i}>${i}</a>`;
            }
            html += `</div>`;
            $(".ems_row").append(html);




            // let size_li = $(".ems_more_card").size();
            // console.log(size_li);
            // $(".ems_more_card").slice(0, 4).show();
            // $("body").on('click touchstart', '.load-more', function (e) {
            //     e.preventDefault();
            //     $(".ems_more_card:hidden").slice(0, 4).slideDown();
            //     if ($(".ems_more_card:hidden").length == 0) {
            //         $(".load-more").css('visibility', 'hidden');
            //     }
            //     $('html,body').animate({
            //         scrollTop: $(this).offset().top
            //     }, 1000);
            // });

        }

        function viewEvent() {
            let id = $(this).closest('.card').find('.event_id').text();
            let singleEvent = {};

            const that = this;
            $.get(ajax_url.ajaxurl, {
                action: "ems_events_user_ajax",
                route: "get_single_eventData",
                id: id,
                ems_nonce: ajax_url.ems_nonce,
            },
                function (data) {
                    that.singleEvent = data.data.single_event_data;
                    let value = JSON.parse(that.singleEvent.eventData);
                    let html = '';

                    $('.image').find('img').attr("src", value.image);
                    $('.ems_starting_date').html(value.startingDate);
                    $('.ems_ending_date').html(value.endingDate);
                    $('.ems_location').html(value.location);
                    $('.ems_event_category').html(value.category);
                    $('.ems_event_deadline').html(value.deadline);
                    $('.ems_event_type').html(value.onlineEvent);
                    $('.ems_spots_left_value').html(value.limit + " spots left");



                    html += `<div class="wrap">`;
                    // html += `<div class="image"><img src="${value.url}" alt="" ></div>`;
                    html += `<div class="details">`;
                    html += `<div id="${id}" class="event_id"><b>ID:</b> ${id}</div>`;
                    html += `<div title="${value.title}" class="ems_title"><b> ${value.title}</b><hr></div>`;
                    html += `<div class="ems_event_details">`
                    // html += `<div><b>Category:</b> ${value.category}</div>`;
                    html += `<div><b>Details:</b> ${value.details}</div>`;
                    // html += `<div><b>Starting Date:</b> ${value.startingDate}</div>`;
                    // html += `<div><b>Starting Time:</b> ${value.startingTime}</div>`;
                    // html += `<div><b>Ending Date:</b> ${value.endingDate}</div>`;
                    // html += `<div><b>Ending Time:</b> ${value.endingTime}</div>`;
                    // html += `<div><b>Organizer:</b> ${value.organizer}</div>`;
                    // html += `<div><b>Deadline:</b> ${value.deadline}</div>`;
                    // html += `<div><b>Registration left:</b> ${value.limit}</div>`;
                    // html += `<div><b>Location:</b> ${value.location}</div>`;
                    // html += `<div><b>Online Event:</b> ${value.onlineEvent}</div>`;
                    // html += `<hr></div>`
                    // html += `<div class="button"><button type="button" class="btn btn-primary  float-right registerEvent">Register</button></div>`

                    html += `</div>`;
                    html += `</div>`;
                    $("#ems_event_view").modal("show");
                    $("#ems_event_data").html(html).show();

                }).fail(function (error) {
                    alert(error.responseJSON.data.error);
                });
        }

        function handleRegisterEvent(user) {
            $.post(ajax_url.ajaxurl, {
                action: 'ems_events_user_ajax',
                route: "insert_registration_data",
                data: user,
                ems_nonce: ajax_url.ems_nonce,
            },
                function (data) {
                    handleModelMessage();
                    $("#ems_registration_form").trigger("reset");
                    $('#ems_success').html(data.data.message).fadeIn('slow').css("color", "green");
                    fetchEventData();

                }).fail(function (error) {
                    handleModelMessage();
                    $('#ems_error').html(error.responseJSON.data.error).fadeIn('slow').css("color", "red");
                    if (error.responseJSON.data.name && error.responseJSON.data.email) {
                        $('.ems_name_error').html(error.responseJSON.data.name).fadeIn('slow');
                        $('.ems_email_error').html(error.responseJSON.data.email).fadeIn('slow');
                    } else {
                        if (error.responseJSON.data.name) {
                            $('.ems_name_error').html(error.responseJSON.data.name).fadeIn('slow');
                        } if (error.responseJSON.data.email) {
                            $('.ems_email_error').html(error.responseJSON.data.email).fadeIn('slow');
                        }
                    }
                })
        }

        function handleModelMessage() {
            $('.ems_name_error').hide();
            $('.ems_email_error').hide();
            $('#ems_success').hide()
        }
    });
})(jQuery);