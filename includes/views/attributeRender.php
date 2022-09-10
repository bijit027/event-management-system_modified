<div class="container">
  <div class="ems_filter">
    <form action="">
      <label>Category:</label>
      <select name="" class="ems_category">
        <option value="" selected>All</option>
        <?php
        $taxonomy = 'eventCategory';
        $data = get_terms(array(
          'taxonomy' => $taxonomy,
          'hide_empty' => false,
        ));
        foreach ($data as $termData) : ?>

          <option value="<?php esc_html_e($termData->term_id) ?>"><?php esc_html_e($termData->name) ?></option>

        <?php endforeach; ?>








      </select>
      <label>OrderBy:</label>
      <select name="" class="ems_orderBy">
        <option value="" selected>None</option>
        <option value="date" select>Date</option>
        <option value="title" select>Title</option>
        <option value="id" select>ID</option>
      </select>
      <label>Order:</label>
      <select name="" class="ems_order">
        <option value="" selected>None</option>
        <option value="ASC" select>ASC</option>
        <option value="DESC" select>DESC</option>
      </select>
    </form>
  </div>
  <div class="row ems_row">

  </div><br>
  <h3 class="ems_category_error"></h3>
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
      <div class="modal-body" id="ems_event_data" style="overflow-x: scroll;">
        //ajax success content here.
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
          <b>Event: </b>
          <p class="ems_event_title"></p>
          <div class="form-group">
            <span class="required">*</span>
            <label for="recipient-name" class="col-form-label">Name:</label>
            <input type="text" name="name" class="form-control" id="recipient-name">
            <p class="ems_name_error"></p>
          </div>
          <div class="form-group">
            <span class="required">*</span>
            <label for="exampleInputEmail1">Email address</label>
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