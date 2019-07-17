<div ng-init="initDOMMain(); checkSession(); getSession()" class="container-fluid p-0">
    <div class="panel-default">
        <div id="header" class="panel-heading p-3 bg-secondary" style="height:15%">
            <div class="row" style="height:100%" >
                <div class="col-sm my-auto">
                    <h2 class="text-white"><i>IUKL SEMMS</i></h2>
                </div>
                <div class="my-auto">
                    <div class="row bg-info border border-info rounded">
                            <p class="col-sm my-auto text-white" data-toggle="tooltip" title="{{last_login}}" ng-cloak><b><i>{{name}}</i> [<i>{{user_type}}</i>]</b></p>
                            <button class="my-auto btn btn-md p-3 text-white rounded-0" data-toggle="tooltip" data-target="#editProfileModal" ng-click="openEditProfileModal()" title="Edit Profile"><i class="fas fa-cog"></i></button>
                    </div>
                </div>
                <div class="my-auto ml-4 mr-3">
                    <button class="my-auto btn btn-danger text-white btn-md p-3" ng-click="logout()" data-toggle="tooltip" title="Sign out"><div class="row justify-content-center"><i id="logoutIcon" class="fas fa-sign-out-alt my-auto"></i><div id="logoutSpinner" class="spinner-border spinner-border-sm text-white my-auto"></div></div></button>
                </div>
            </div>
        </div>
        <div style="height:85%" class="bg-dark panel-body"><div ui-view></div></div>
        <!-- <div style="height:8%; font-size:10pt" class="bg-secondary panel-footer text-center text-white pt-2">
            Copyright &copy; <b>2019 Student Exam Misconduct Unit.</b> All rights reserved.
        </div> -->
    </div>
</div>
<!-- Edit Profile Modal -->
<div ng-controller="userCtrl" class="modal fade" id="editProfileModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" >
		<div class="modal-content">
			<div class="modal-header bg-info text-white">
				<h4><strong>Edit My Profile</strong></h4>
				<button type="button" class="close btn btn-link text-white" data-dismiss="modal">&times;</button>
			</div>
			<form ng-submit="saveEditProfile(edit)">
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
                            <div id="confirmPasswordAlert1" class="alert alert-warning" role="alert">
                                Password do not match!
                            </div>
                        </div>
                    </div>
				</div>
				<div class= "modal-footer">
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