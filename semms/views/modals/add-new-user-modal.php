<!-- Add new user modal -->
<div class="modal-header bg-primary text-white">
    <h4><strong>Register User</strong></h4>
    <button type="button" class="close btn btn-link text-white" ng-click="cancelRegisterUser(new)">&times;</button>
</div>
<form id="addNewUserModalForm" ng-submit="registerUser(new)">
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="staff_id"><strong>Staff ID</strong></label>
                    <input type="text" class="form-control" placeholder="Enter user staff id..." ng-keyup="checkExistingId(new.staff_id)" ng-model="new.staff_id" required>
                </div>
                <div style="display:none" id="existedIdAlert" class="alert alert-warning" role="alert">
                    Staff ID already taken!
                </div>
                <div class="form-group">
                    <label for="name"><strong>Name</strong></label>
                    <input type="text" class="form-control" placeholder="Enter user name..." ng-model="new.name" required>
                </div>
                <div class="form-group">
                    <label for="email"><strong>Email</strong></label>
                    <input type="email" class="form-control" placeholder="Enter user email..." ng-model="new.email" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="contact_no"><strong>Contact Number</strong></label>
                    <input type="text" class="form-control" placeholder="Enter user contact number..." ng-model="new.contact_no" required>
                </div>
                <div class="form-group">
                    <label for="user_type"><strong>Access</strong></label>
                    <select class="form-control" ng-model="new.user_type" required>
                        <option value="">Select a user access</option>
                        <option>Admin</option>
                        <option>Bursary Admin</option>
                        <option>Counselor</option>
                        <option>Invigilator</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class= "modal-footer">
        <button class="btn btn-danger" type="button" ng-click="cancelRegisterUser(new)"><strong><i class="fas fa-times"></i> Close</strong></button>
        <button class="btn btn-success" type="submit">
            <div style="display:none" id="saveSpinner" class="spinner-border spinner-border-sm text-white"></div>
            <strong ><i id="saveIcon" class="fas fa-check"></i> Save</strong>
        </button>
    </div>
</form>