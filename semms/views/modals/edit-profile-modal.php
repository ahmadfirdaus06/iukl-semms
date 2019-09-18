<!-- Edit Profile Modal -->
<div id="modal" class="modal-header bg-dark text-white">
    <h4><strong>Edit My Profile</strong></h4>
    <button type="button" class="close btn btn-link text-white" ng-click="close()">&times;</button>
</div>
<form ng-submit="save()">
    <div class="modal-body">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="name"><strong>Name</strong></label>
                    <input type="text" class="form-control" ng-model="edit.name" readonly>
                </div>
                <div class="form-group">
                    <label for="email"><strong>Email</strong></label>
                    <input type="email" class="form-control" ng-model="edit.email" required>
                </div>
                <div class="form-group">
                    <label for="contact_no"><strong>Contact Number</strong></label>
                    <input type="text" class="form-control" ng-model="edit.contact_no" required>
                </div>
                <div class="form-group">
                    <label for="registered_by"><strong>Registered By</strong></label>
                    <input type="text" class="form-control" ng-model="edit.created_date" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="last_login"><strong>Last Logged In</strong></label>
                    <input type="text" class="form-control" ng-model="edit.last_login" readonly>
                </div>
                <hr>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="change_password1" ng-model="edit.change_password">
                    <label class="custom-control-label" for="change_password1">  Change Password</label>
                </div>
                <br>
                <div class="form-group">
                    <label for="new_password"><strong>New Password</strong></label>
                    <input type="password" class="form-control" ng-model="edit.new_password" ng-disabled="!edit.change_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password"><strong>Confirm Password</strong></label>
                    <input type="password" class="form-control" ng-model="edit.confirm_password" ng-disabled="!edit.new_password || !edit.change_password" required>
                </div>
                <div style="display:none" id="confirmPasswordAlert1" class="alert alert-warning" role="alert">
                    Password do not match!
                </div>
            </div>
        </div>
    </div>
    <div class= "modal-footer">
        <button class="btn btn-danger" type="button" ng-click="close()"><strong><i class="fas fa-times"></i> Close</strong></button>
        <button class="btn btn-success" type="submit">
            <div style="display:none" id="saveSpinner" class="spinner-border spinner-border-sm text-white"></div>
            <strong ><i id="saveIcon" class="fas fa-check"></i> Save</strong>
        </button>
    </div>
</form>