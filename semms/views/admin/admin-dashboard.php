<div id="content" class="container-fluid p-3" style="background-color: inherit" ng-app="semms" ng-init="get()">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="p-0 col my-auto">
                <input type="text" class="form-control border border-secondary" ng-keyup="searchTable(text)" ng-model="text" style="width:25%" placeholder="Search user....">
            </div>
            <div class="p-0 row mr-1">
                <button class="my-auto btn btn-primary" title="Add New User"data-target="#addNewUserModal" data-toggle="modal"><i class="fas fa-user-plus"></i> New User</button>
                <p class="my-auto ml-2 mr-auto text-white">Total Users: {{totalUser}}</p>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-white card p-3 mt-3">
        <div id="loading" class="row justify-content-center text-dark">
            <div class="spinner-border spinner-border-sm my-auto"></div> 
            <span class="my-auto ml-3">Loading....</span>
        </div>
        <table id="userTable" class="table table-bordered table-hover">
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
</div>
<!-- Edit User Data Modal -->
<div ng-controller="adminCtrl" class="modal fade" id="editUserDataModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" >
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4><strong>Edit User</strong></h4>
				<button type="button" class="close btn btn-link text-white" data-dismiss="modal">&times;</button>
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
                    <!-- <button class="btn btn-warning text-white" ng-click="removeUser(edit)" type="button">
                        <div id="deleteSpinner" class="spinner-border spinner-border-sm text-white"></div>
                        <strong><i id="deleteIcon" class="fas fa-exclamation-triangle"></i> Remove User</strong>
                    </button> -->
					<button class="btn btn-danger" data-dismiss="modal"><strong><i class="fas fa-times"></i> Close</strong></button>
                    <button class="btn btn-success" type="submit">
                        <div id="saveSpinner" class="spinner-border spinner-border-sm text-white"></div>
                        <strong ><i id="saveIcon" class="fas fa-check"></i> Save</strong>
                    </button>
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
                            <div id="existedIdAlert" class="alert alert-warning" role="alert">
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
                        <div id="saveSpinner" class="spinner-border spinner-border-sm text-white"></div>
                        <strong ><i id="saveIcon" class="fas fa-check"></i> Save</strong>
                    </button>
				</div>
			</form>
		</div>
	</div>
</div>