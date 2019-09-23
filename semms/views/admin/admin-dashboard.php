<div class="container-fluid p-0 stylish-color" style="height:100%; overflow:hidden" ng-app="semms" ng-init="getDashboard()">
    <div class="container-fluid special-color-dark" style="height:10%">
        <div class="row" style="height:100%">
            <ul class="nav nav-pills">
                <li class="nav-item my-auto">
                    <a class="nav-link" href="#!/main/admin/dashboard"><h4 class="my-auto text-white"><strong>My Dashboard</strong></h4></a>
                </li>                                         
            </ul>    
            <span class="col"></span>
            <button class="my-auto btn btn-white mr-3" title="Add New User" data-target="#addNewUserModal" data-toggle="modal"><strong><i class="fas fa-user-plus"></i> New User</strong></button>
        </div>
    </div>
    <div  id="content" class="container-fluid p-3" style="height:90%; overflow-y:auto; display:none">
        <div class="wrapper">
            <div class="container-fluid card p-0" style="height:auto">
                <div class="card-header special-color-dark text-white">
                    <div class="row p-0">
                        <h5 class="my-auto col"><strong>All Users</strong> <span ng-if="totalUser != 0" class="my-auto badge badge-pill badge-light">{{totalUser}}</span></h5>
                        <input type="text" class="my-auto mr-3 form-control" ng-keyup="searchTable(text)" ng-model="text" style="width:25%" placeholder="Search user....">
                    </div>
                </div>
                <div class="card-body p-0" style="width:100%">
                    <table id="userTable" class="table table-bordered table-hover" style="margin:0 !important; width:100%">
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
                                <td style="text-align:center"><button data-toggle="tooltip" title="Edit User Data" ng-click="openEditUserDataModal(user)" class="btn btn-sm m-0 btn-primary"><i class="fas fa-user-edit"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                            <div style="display:none" id="confirmPasswordAlert2" class="alert alert-warning" role="alert">
                                Password do not match!
                            </div>
                        </div>
                    </div>
				</div>
				<div class= "modal-footer">
					<button class="btn btn-danger" data-dismiss="modal"><strong><i class="fas fa-times"></i> Close</strong></button>
                    <button class="btn btn-success" type="submit">
                        <div style="display:none" id="saveSpinner" class="spinner-border spinner-border-sm text-white"></div>
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
		</div>
	</div>
</div>