<div class="container-fluid bg-white p-2 card" ng-app="semms" ng-init="getAllUser()">
    <input type=hidden ng-model="pageAccess" ng-init="pageAccess='Admin'">
    <div>
        <button class="btn btn-primary" title="Add New User" data-toggle="tooltip">New User</button>
    </div>
    <div id="loading" style="margin:0 auto" class="spinner-border text-primary my-auto"></div>
    <br>
    <table
    id="userTable"
    class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Staff ID</th>
                <th>Access Type</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="user in allUser">
                <td>{{$index+1}}</td>
                <td>{{user.name}}</td>
                <td>{{user.staff_id}}</td>
                <td>{{user.user_type}}</td>
            </tr>
        </tbody>
    </table>
</div>