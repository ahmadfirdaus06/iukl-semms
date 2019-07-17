<div ng-app="semms" ng-init="initDOMLogin(); checkSession()"  class=" bg-dark container-fluid m-0" style="height:100%">
</div>
<!-- Login Modal -->
<div ng-controller="userCtrl" class="modal fade" id="loginModal" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" >
		<div class="modal-content">
		
			<div class="modal-header">
				<h4 style="margin:0 auto"><strong>IUKL SEMMS</strong></h4>
			</div>
			<form ng-submit="login()">
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
					<button style="margin:0 auto; float:none" type="submit" class="btn btn-block btn-lg btn-dark">
						<div class="row justify-content-center">
							<span class="my-auto col-2"><strong>Login</strong></span>
							<div id="loginSpinner" class="spinner-border text-white my-auto"></div>
						</div>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>






