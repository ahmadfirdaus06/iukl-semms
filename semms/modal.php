<!-- Login Modal -->
<div ng-controller="userCtrl" class="modal fade" id="loginModal" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" >
		<div class="modal-content">
		
			<div class="modal-header">
				<h4 style="margin:0 auto"><strong>IUKL SEMMS</strong></h4>
			</div>
			<form>
				<div class="modal-body">
					<div class="form-group">
						<label for="staff_id"><strong>ID</strong></label>
						<input type="text" class="form-control" id="staff_id" ng-model="staff_id" autofocus required>
					</div>
					<div class="form-group">
						<label for="password"><strong>Password</strong></label>
						<input type="password" class="form-control" id="password" ng-model="password" required>
					</div>
					<div id="loginAlert" class="alert alert-danger" role="alert">
						Wrong ID or Password!
					</div>
				</div>
				<div class= "modal-footer">
					<button class="btn btn-block btn-lg btn-dark" ng-click="login()"><strong>Login</strong></button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Edit Profile Modal -->
<div ng-controller="userCtrl" class="modal fade" id="editProfileModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" >
		<div class="modal-content">
			<div class="modal-header">
				<h4><strong>Edit My Profile</strong></h4>
				<button type="button" class="close btn btn-link" data-dismiss="modal">&times;</button>
			</div>
			<form>
				<div class="modal-body">
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
					<hr>
					<div class="form-check">
						<input type="checkbox" class="form-check-input" ng-model="edit.change_password">
						<label class="form-check-label" >Change Password</label>
					</div>
					</br>
					<div class="form-group">
						<label for="new_password"><strong>New Password</strong></label>
						<input type="password" class="form-control" ng-model="edit.new_password" ng-disabled="!edit.change_password" required>
					</div>
					<div class="form-group">
						<label for="confirm_password"><strong>Confirm Password</strong></label>
						<input type="password" class="form-control" ng-model="edit.confirm_password" ng-disabled="!edit.new_password || !edit.change_password" required>
					</div>
					<div id="confirmPasswordAlert" class="alert alert-warning" role="alert">
						Password do not match!
					</div>
				</div>
				<div class= "modal-footer">
					<button class="btn btn-success" ng-click="saveEditProfile(edit)"><strong>Save</strong></button>
					<button class="btn btn-danger" data-dismiss="modal"><strong>Close</strong></button>
				</div>
			</form>
		</div>
	</div>
</div>