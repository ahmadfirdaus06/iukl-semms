<!-- Login Modal -->
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
        <div style="display:none" id="loginAlert" class="alert alert-danger" role="alert">
            Wrong ID or Password!
        </div>
    </div>
    <div class= "modal-footer">
        <button style="margin:0 auto; float:none" type="submit" class="btn special-color-dark text-white btn-block btn-lg">
            <div class="row">
                <span class="my-auto col-4"></span>
                <span class="my-auto col-4"><strong>Login</strong></span>
                <div style="display:none" id="loginSpinner" class="spinner-border text-white my-auto"></div>
            </div>
        </button>
    </div>
</form>