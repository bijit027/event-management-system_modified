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
                $(".category").append(html);          
            }
        );
        var eventCategory = "";
        var orderBy = "";
        var order = "";

        $(".category,.orderBy,.order").each(function(){
            $(this).on("change",function(){
                this.orderBy    =  $(".orderBy").val();
                this.eventCategory    =  $(".category").val();
                this.order    =  $(".order").val();
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
                    $(".row").empty();
                    alert(error.responseJSON.data.error); 
                    
                });

            }

        async function renderEventCards(events)
        {
            $(".row").empty();
            $(".card-content").html('');
            var url = window.location.href;
            $(".row").append('');
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
                html += `<div class="card-text event_title"><b>Title:</b> ${title}</div>`;
                html += `<div class="card-text event_category"><b>Category:</b> ${event.category}</div>`;
                html += `<div><button type="button" class="btn btn-primary viewEvent">View</button></div>`
                html += `</div>`;
                html += `</div>`;
                html += `</div>`;
                
                $(".row").append(html);
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
                    console.log(data.data.single_event_data);
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
                    $("#getCodeModal").modal("show");
                    $("#getCode").html(html).show();
    
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
           
            $('#getCodeModal').modal('hide');
            $("#exampleModal").modal("show");
            $('#registrationForm').on('submit', function(e) {
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

                        $('#success').html(data.data.message).fadeIn('slow').css("color","green");
                        $("#registrationForm").trigger("reset");
                        $('.name-error').hide();
                        $('.email-error').hide();
                    
                    }).fail(function(error) {
                        $('#error').html(error.responseJSON.data.error).fadeIn('slow').css("color","red");
                        $('#success').hide();
                        if(error.responseJSON.data.name != ""){
                            $('.name-error').html(error.responseJSON.data.name).fadeIn('slow');
                            
                        }if(error.responseJSON.data.email !="" ){
                            
                            $('.email-error').html(error.responseJSON.data.email).fadeIn('slow');
                            
                        }
                    })
            });
            
        });

    });

    });
    
})(jQuery);