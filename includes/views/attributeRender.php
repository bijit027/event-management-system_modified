<div class="container">

  <div class="ems_filter">
    <form action="">
      <div class="ems_filter_table">
        <!-- <label>Category:</label> -->
        <select name="" class="ems_category">
          <option value="" selected>Choose Category</option>
          <?php
          $taxonomy = 'eventCategory';
          $data = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
          ));
          foreach ($data as $termData) : ?>
            <option value="<?php _e($termData->term_id) ?>"><?php _e($termData->name) ?></option>
          <?php endforeach; ?>
        </select>
        <!-- <label>OrderBy:</label> -->
        <select name="" class="ems_orderBy">
          <option value="" selected>OrderBy</option>
          <option value="date" select>Date</option>
          <option value="title" select>Title</option>
          <option value="id" select>ID</option>
        </select>
        <!-- <label>Order:</label> -->
        <select name="" class="ems_order">
          <option value="" selected>Order</option>
          <option value="ASC" select>ASC</option>
          <option value="DESC" select>DESC</option>
        </select>
      </div>
    </form>

  </div>
  <div class="row ems_row">

  </div><br>
  <!-- <div id="loadMore" style=""> -->
  <!-- <a href="" class="load-more">Load More</a> -->

  <div id="pagination-container"></div>
  <!-- </div> -->
  <h3 class="ems_event_error"></h3>
</div>



<!-- Modal -->
<div class="modal fade" id="ems_event_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Event Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="image"><img src="" alt=""></div>
      <div class="row ems_view">
        <div class="col-md-6 modal-body" id="ems_event_data" style="overflow-x: hide;">
          //ajax success content here.
        </div>
        <div class=" col-md-4 ems_register_form">


          <form id="ems_registration_form">
            <div class="ems_event_name">
              <b>Register for event
                <p class="ems_event_title"></p>
              </b>
            </div>
            <div class="form-group">
              <span class="required">*</span>
              <label for="recipient-name" class="col-form-label">Name:</label>
              <input type="text" name="name" class="form-control" id="recipient-name">
              <p class="ems_name_error"></p>
            </div>
            <div class="form-group">
              <span class="required">*</span>
              <label for="exampleInputEmail1" class="col-form-label">Email address:</label>
              <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
              <p class="ems_email_error"></p>
            </div>
            <div id="ems_success"></div>
            <div id="ems_error"></div>
            <div class="footer">
              <button type="submit" id="ems_register_submit" class="btn btn-primary btn-block btn-sm ems_register_submit">Register</button>

            </div>
          </form>

          <div class="ems_spots_left">
            <b>
              <p class="ems_spots_left_value"></p>
            </b>
          </div>

          <div class="ems_details">
            <b>Starting Date
            </b>
            <p class="ems_starting_date"></p>
            <b>Ending Date
            </b>
            <p class="ems_ending_date"></p>
            <b>Event Location
            </b>
            <p class="ems_location"></p>
            <b>Deadline
            </b>
            <p class="ems_event_deadline"></p>

            <b>Event Type
            </b>
            <p class="ems_event_type"></p>

            <b>Event Category
            </b>
            <p class="ems_event_category"></p>
            <div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!--Registration for event-->
    <div class="modal fade" id="ems_registration_view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Register For Event</h5></br>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="ems_registration_form">
              <div class="ems_event_name">
                <b>Register for event
                  <p class="ems_event_title"></p>
                </b>
              </div>
              <div class="form-group">
                <span class="required">*</span>
                <label for="recipient-name" class="col-form-label">Name:</label>
                <input type="text" name="name" class="form-control" id="recipient-name">
                <p class="ems_name_error"></p>
              </div>
              <div class="form-group">
                <span class="required">*</span>
                <label for="exampleInputEmail1" class="col-form-label">Email address:</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <p class="ems_email_error"></p>
              </div>
              <div id="ems_success"></div>
              <div id="ems_error"></div>
              <div class="modal-footer">
                <button type="submit" id="ems_register_submit" class="btn btn-primary btn-block ems_register_submit">Register</button>
                <button type="button" class="btn btn-secondary btn-block ems_register_close" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>