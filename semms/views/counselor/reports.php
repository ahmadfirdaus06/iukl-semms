<div class="container-fluid p-3" ng-init="verifySession()" style="background-color: inherit" ng-app="semms">
    <input type=hidden ng-model="pageAccess" ng-init="pageAccess='Counselor'">
    <div class="container-fluid">
        <div class="row">
            <ul class="nav nav-pills">
                <li class="nav-item my-auto">
                    <a class="nav-link" href="#!/main/counselor/dashboard"><h4 class="my-auto text-white"><small>My Dasboard</small></h4></a>
                </li>
                <li class="nav-item my-auto">
                    <a class="nav-link"><h4 class="my-auto text-white"><span><i class="fas fa-chevron-right"></i></span></h4></a>
                </li>     
                <li class="nav-item my-auto">
                    <a class="nav-link" href="#!/main/counselor/reports"><h4 class="my-auto text-white">Reports</h4></a>
                </li>                                         
            </ul>   
        </div>
    </div>
    <div class="container-fluid bg-white card p-0 mt-3">
        <div class="card-body p-0">
            <div class="card-header bg-primary text-white">
                <h5 class="my-auto">Notification Panel</h5>
            </div>
            <div class="card-body p-0">
                <!-- <div id="loading" class="row justify-content-center text-dark">
                    <div class="spinner-border spinner-border-sm my-auto"></div> 
                    <span class="my-auto ml-3">Loading....</span>
                </div> -->
                <table id="userTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="notification in notifications" title="Click for more details">
                            <td>{{$index+1}}</td>
                            <td>{{notification.subject}}</td>
                            <td>{{notification.description}}</td>
                            <td>{{notification.date_created}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>