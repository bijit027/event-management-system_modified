(function ($) {
    "use strict";
    $(document).ready(function () {
        var events = [];

        $.ajax({
            type: "GET",
            url: ajax_url.ajaxurl,
            dataType: "json",
            data: {
                action: "ems_get_event_data",
            },
            success: function (data) {
                events =  data.data;
                renderEventCards(events);

            },
            error: function (error) {},
        });

        function renderEventCards(events)
        {
            var html = '';
            $(".card-content").html('');
            var url = window.location.href;
            
            $.each(events, function (index, value) {

                var Id = value.ID;
                var title = value.post_title;
                var content = JSON.parse(value.post_content);
               
                html += `<div class="col-sm-4">`;
                html += `<div class="card">`;
                html += `<div class="card-image"><img class="" src="${content.url}" alt=""></div>`;
                html += `<div class="card-body card-info">`;
                html += `<div class="card-text event_id">${Id}</div>`;
                html += `<div class="card-text event_title"><b>Title:</b> ${title}</div>`;
                html += `<div class="card-text event_category"><b>Category:</b> ${content.category}</div>`;
                html += `<div><button type="button" class="btn btn-primary viewEvent">View</button></div>`
                html += `<div><button type="button" class="btn btn-primary registerEvent">Register</button></div>`

                html += `</div>`;
                html += `</div>`;
                html += `</div>`;
            });
            $(".row").append(html);
        }
        
        //View Event
        $(document).on("click",".viewEvent",function()
        {
            var id = $(this).closest('.card').find('.event_id').text();
            var singleEvent = {};
            
            const that = this;
            $.ajax({
                
            type: "GET",
            url: ajax_url.ajaxurl,
            dataType: "json",
            data: {
                action: "ems_get_single_event_data",
                id: id
            },
            success: function (data) {
                that.singleEvent =  data.data;
                var value = JSON.parse(that.singleEvent.eventData);
                var html = '';

                html += `<div>`;
                html += `<div class="image"><img src="${value.url}" alt=""></div>`;
                html += `<div>`;
                html += `<div><b>ID:</b> ${id}</div>`;
                html += `<div><b>Title:</b> ${value.title}</div>`;
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

                html += `</div>`;
                html += `</div>`;
                $("#getCodeModal").modal("show");
                $("#getCode").html(html).show();

            },
            error: function (error) {},
        });

        //Register Event
        $(document).on("click",".registerEvent",function()
        {
            var eventId = $(this).closest('.card').find('.event_id').text();
            var eventTitle = $(this).closest('.card').find('.event_title').text();

            $("#exampleModal").modal("show");
            $('#registrationForm').on('submit', function(e) {
                e.preventDefault();
                let name = $('input[name="name"]').val();
                let email = $('input[name="email"]').val();
                          
                $.ajax({
                    type: "POST",
                    url: ajax_url.ajaxurl,
                    dataType: "json",
                    data: {
                        action: "ems_insert_registration_data",
                        eventId: eventId,
                        eventTitle: eventTitle,
                        name: name,
                        email: email,
                        ems_nonce: ajax_url.ems_nonce,
                    },
                    success: function(data) {

                        $('#success').html(data.data.message).fadeIn('slow');
                        $("#registrationForm").trigger("reset");
                        console.log(data.data.message);
                    
                    },
                    error: function (error) {
                        $('#error').html(error.responseJSON.data.error).fadeIn('slow');
                     
                        if(error.responseJSON.data.name != ""){
                           
                            $('.name-error').html(error.responseJSON.data.name).fadeIn('slow');
                            
                        }if(error.responseJSON.data.email !="" ){
                            
                            $('.email-error').html(error.responseJSON.data.email).fadeIn('slow');
                            
                        }
                    }
                });
            });
            
        });

    });

    });
    
})(jQuery);