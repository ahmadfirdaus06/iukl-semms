<div class="container-fluid bg-white p-2 card" ng-app="semms" ng-init="initDOMAdmin(); getAllUser()">
    <input type=hidden ng-model="pageAccess" ng-init="pageAccess='Admin'">
    <div class="row m-1">
        <input type="text" class="form-control border border-primary" ng-keyup="searchTable(text)" ng-model="text" style="width:30%" placeholder="Search user....">
        <button class="btn btn-primary ml-auto" title="Add New User"data-target="#addNewUserModal" data-toggle="modal"><i class="fas fa-user-plus"></i> New User</button>
    </div>
    <div id="loading" style="margin:0 auto" class="spinner-border text-primary my-auto"></div>  
    <table
    id="userTable"
    class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Staff ID</th>
                <th>Access Type</th>
                <th>Registered By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="user in allUser">
                <td>{{$index+1}}</td>
                <td>{{user.name}}</td>
                <td>{{user.staff_id}}</td>
                <td>{{user.user_type}}</td>
                <td>{{user.created_date | date: 'medium'}}</td>
                <td style="text-align:center"><button data-toggle="tooltip" title="Edit User Data" ng-click="openEditUserDataModal(user)" class="btn btn-primary"><i class="fas fa-user-edit"></i></button></td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Edit User Data Modal -->
<div ng-controller="adminCtrl" class="modal fade" id="editUserDataModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" >
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4><strong>Edit User</strong></h4>
				<button type="button" class="close btn btn-link" data-dismiss="modal">&times;</button>
			</div>
			<form ng-submit="saveEditUserData(edit)">
				<div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="staff_id"><strong>Staff ID</strong></label>
                                <input type="text" class="form-control" ng-model="edit.staff_id" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name"><strong>Name</strong></label>
                                <input type="text" class="form-control" ng-model="edit.name" required>
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
                                <label for="user_type"><strong>Access</strong></label>
                                <select class="form-control" ng-model="edit.user_type" required>
                                    <option>Admin</option>
                                    <option>Bursary Admin</option>
                                    <option>Counselor</option>
                                    <option>Invigilator</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="registered_by"><strong>Registered By</strong></label>
                                <input type="text" class="form-control" ng-model="edit.created_date" readonly>
                            </div>
                            <div class="form-group">
                                <label for="last_login"><strong>Last Logged In</strong></label>
                                <input type="text" class="form-control" ng-model="edit.last_login" readonly>
                            </div>
                            <div class="form-group">
                                <label for="granted_access"><strong>Granted Access</strong></label>
                                <select class="form-control" ng-model="edit.granted_access" required>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                            <hr>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="change_password2" ng-model="edit.change_password">
                                <label class="custom-control-label" for="change_password2">  Change Password</label>
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
                            <div id="confirmPasswordAlert2" class="alert alert-warning" role="alert">
                                Password do not match!
                            </div>
                        </div>
                    </div>
				</div>
				<div class= "modal-footer">
                    <button class="btn btn-warning text-white" type="button"><strong><i class="fas fa-exclamation-triangle"></i> Remove User</strong></button>
					<button class="btn btn-success" type="submit"><strong><i class="fas fa-check"></i> Save</strong></button>
					<button class="btn btn-danger" data-dismiss="modal"><strong><i class="fas fa-times"></i> Close</strong></button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Add New User Modal -->
<div ng-controller="adminCtrl" class="modal fade" id="addNewUserModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" >
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4><strong>Register User</strong></h4>
				<button type="button" class="close btn btn-link" data-dismiss="modal">&times;</button>
			</div>
			<form ng-submit="">
				<div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="staff_id"><strong>Staff ID</strong></label>
                                <input type="text" class="form-control" ng-model="new.staff_id" required>
                            </div>
                            <div class="form-group">
                                <label for="name"><strong>Name</strong></label>
                                <input type="text" class="form-control" ng-model="new.name" required>
                            </div>
                            <div class="form-group">
                                <label for="email"><strong>Email</strong></label>
                                <input type="email" class="form-control" ng-model="new.email" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="contact_no"><strong>Contact Number</strong></label>
                                <input type="text" class="form-control" ng-model="new.contact_no" required>
                            </div>
                            <div class="form-group">
                                <label for="user_type"><strong>Access</strong></label>
                                <select class="form-control" ng-model="new.user_type" required>
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
                    <button class="btn btn-success" type="submit"><strong><i class="fas fa-check"></i> Save</strong></button>
					<button class="btn btn-danger" data-dismiss="modal"><strong><i class="fas fa-times"></i> Close</strong></button>
				</div>
			</form>
		</div>
	</div>
</div>