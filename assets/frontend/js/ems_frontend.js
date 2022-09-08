(function ($) {
    
    $(document).ready(function () {
        
        var that = this; 
        var category = [];                   
        $.get(ajax_url.ajaxurl, {        
            ems_nonce: ajax_url.ems_nonce, 
            action: 'ems_events_admin_ajax',    
            route: 'get_category_Data',                      
            }, function(data) {                   
                that.category = data.data.term_data;  
                fetchEventData('','','');
                var html = '';
                $.each(that.category, function (index, value) {
                    html += `<option value="${value.term_id}">${value.name}</option>`;
                })
                $(".ems_category").append(html);          
            }
        );
        var eventCategory = "";
        var orderBy = "";
        var order = "";

        $(".ems_category,.ems_orderBy,.ems_order").each(function(){
            $(this).on("change",function(){
                this.orderBy    =  $(".ems_orderBy").val();
                this.eventCategory    =  $(".ems_category").val();
                this.order    =  $(".ems_order").val();
                $(".ems_category_error").empty();
                fetchEventData(this.eventCategory,this.orderBy,this.order);
            });
        })
        
        var events = [];
            var that = this;  
            function fetchEventData(eventCategory,orderBy,order){                   
            $.get(ajax_url.ajaxurl, {        

                action: 'ems_events_admin_ajax',   
                route: 'get_data_for_user',
                category: eventCategory,    
                orderBy: orderBy,
                order: order,
                ems_nonce: ajax_url.ems_nonce,                
                }, function(data) {                   
                    events =  data.data.event_data;
                    renderEventCards(events);             
                }).fail(function(error) {
                    $(".ems_row").empty();
                    $(".ems_category_error").text(error.responseJSON.data.error).css("color","red"); 
                });

            }

        async function renderEventCards(events)
        {
            $(".ems_row").empty();
            $(".card-content").html('');
            var url = window.location.href;
            $(".ems_row").append('');
            $.each(events, async function (index, value) {
                var html = '';

                var Id = value.ID;
                var title = value.post_title;
                var event = {};
                const data = await $.get(ajax_url.ajaxurl, {        
                    ems_nonce: ajax_url.ems_nonce, 
                    action: 'ems_events_admin_ajax',    
                    route: 'get_single_eventData',
                    id: Id,                     
                    })               

                var singleEvent =  data.data.single_event_data;
                event  = JSON.parse(singleEvent.eventData[0]);

                html += `<div class="col-sm-4">`;
                html += `<div class="card">`;
                html += `<div class="card-image"><img class="" src="${event.url}" alt=""></div>`;
                html += `<div class="card-body card-info">`;
                html += `<div class="card-text event_id">${Id}</div>`;
                html += `<div class="card-text event_title"><b> ${title}</b></div>`;
                html += `<div class="card-text ems_location"><small><b>Location: </b>${event.location}</small></div>`;
                html += `<div class="card-text ems_startingDate"><small><b>Date: </b>${event.startingDate}</small></div>`;
                html += `<div><button type="button" class="btn btn-primary viewEvent">View</button></div>`
                html += `</div>`;
                html += `</div>`;
                html += `</div>`;
                
                $(".ems_row").append(html);
            });
        }

        //View Event
        $(document).on("click",".viewEvent",function()
        {
            var id = $(this).closest('.card').find('.event_id').text();
            var singleEvent = {};
            
            const that = this;
            $.get(ajax_url.ajaxurl, { 
                    action: "ems_events_admin_ajax",
                    route: "get_single_eventData",
                    id: id,
                    ems_nonce: ajax_url.ems_nonce,
                },
                function (data) {
                    that.singleEvent =  data.data.single_event_data;
                    var value = JSON.parse(that.singleEvent.eventData);
                    var html = '';
    
                    html += `<div class="wrap">`;
                    html += `<div class="image"><img src="${value.url}" alt=""></div>`;
                    html += `<div>`;
                    html += `<div id="${id}" class="event_id"><b>ID:</b> ${id}</div>`;
                    html += `<div title="${value.title}" class="event_title"><b>Title:</b> ${value.title}</div>`;
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
                    html += `<div class="button"><button type="button" class="btn btn-primary float-right registerEvent">Register</button></div>`
    
                    html += `</div>`;
                    html += `</div>`;
                    $("#ems_event_view").modal("show");
                    $("#ems_event_data").html(html).show();
    
                }).fail(function(error) {
                    alert(error.responseJSON.data.error);   
                });


        //Register Event
        $(document).on("click",".registerEvent",function()
        {
            var user = {
                eventId: '',
                eventTitle: '',
                name: '',
                email: '',

            };
            user.eventId = $(this).closest('.wrap').find('.event_id').attr('id');
            user.eventTitle = $(this).closest('.wrap').find('.event_title').attr('title');
           
            $('#ems_event_view').modal('hide');
            $("#ems_registration_view").modal("show");
            $(".ems_event_title").text(user.eventTitle);
            $('#ems_registration_form').on('submit', function(e) {
                e.preventDefault();
                user.name = $('input[name="name"]').val();
                user.email = $('input[name="email"]').val();

                $.post(ajax_url.ajaxurl, { 
                        action: 'ems_events_admin_ajax',
                        route: "insert_registration_data",
                        data: user,
                        ems_nonce: ajax_url.ems_nonce,
                    },
                   function(data) {

                        $('#ems_success').html(data.data.message).fadeIn('slow').css("color","green");
                        $("#ems_registration_form").trigger("reset");
                        $('.ems_name_error').hide();
                        $('.ems_email_error').hide();
                    
                    }).fail(function(error) {
                        $('#ems_error').html(error.responseJSON.data.error).fadeIn('slow').css("color","red");
                        $('#ems_success').hide();
                        if(error.responseJSON.data.name != ""){
                            $('.ems_name_error').html(error.responseJSON.data.name).fadeIn('slow');
                            
                        }if(error.responseJSON.data.email !="" ){
                            
                            $('.ems_email_error').html(error.responseJSON.data.email).fadeIn('slow');
                            
                        }
                    })
            });
            
        });

    });

    });
    
})(jQuery);