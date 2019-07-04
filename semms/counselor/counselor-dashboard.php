<div ng-init="checkAccess()" class="container-fluid bg-white" style="text-align:center; height:100%" ng-app="semms">
    <input type=hidden ng-model="pageAccess" ng-init="pageAccess='Counselor'">
    <h1 style="text-align:center">This is the admin dashboard page</h1>
    <button ng-controller="userCtrl" class="btn btn-danger" ng-click="logout()">Logout</button>
</div>