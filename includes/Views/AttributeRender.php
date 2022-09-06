<div class="container">
<form action="">
  <label >Category:</label>
  <select name="" class="category">
  <option value="" selected>All</option>
  </select>
  <label >OrderBy:</label>
  <select name="" class="orderBy">
  <option value="" selected>None</option>
  <option value="date" select>Date</option>
  <option value="title" select>Title</option>
  <option value="id" select>ID</option>
  </select>
  <label >Order:</label>
  <select name="" class="order">
  <option value="" selected>None</option>
  <option value="ASC" select>ASC</option>
  <option value="DESC" select>DESC</option>
  
  </select>
</form>
    <div class="row"></div>
</div>



 <!-- Modal -->
 <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Event Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body" id="getCode" style="overflow-x: scroll;">
          //ajax success content here.
       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
   </div>
 </div>

 <!--Registration for event-->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Register For Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="registrationForm">
          <div class="form-group">
            <span class="required">*</span>
            <label for="recipient-name" class="col-form-label">Name:</label>
            <input type="text" name="name" class="form-control" id="recipient-name">
            <p class="name-error"></p>
          </div>
          <div class="form-group">
            <span class="required">*</span>
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            <p class="email-error"></p>
          </div>
          <div id="success"></div>
          <div id="error" ></div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Register</button>
      </div>
        </form>
      </div>
    </div>
  </div>
</div>
