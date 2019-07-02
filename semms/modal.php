<!-- Login Modal -->
<div class="modal fade" id="loginModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog col-sm-6" >
        <div class="modal-content">
			<div class="modal-header">
				<h4 style="margin:0 auto"><strong>IUKL SEMMS</strong></h4>
			</div>
			<div class="modal-body">
				<form autocomplete="false">
					<div class="form-group">
						<label for="staff_id">ID</label>
						<input type="text" class="form-control" id="staff_id" ng-model="staff_id" autofocus>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" ng-model="password">
					</div>
					<div id="loginAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
						Wrong ID or Password!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</form>
			</div>
			<div class= "modal-footer">
				<button class="btn btn-block btn-lg btn-white btn-outline-dark"><strong>Login</strong></button>
			</div>
		</div>
	</div>
</div>