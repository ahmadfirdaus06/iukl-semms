<div class="container-fluid p-0 bg-white" style="height:100%" ng-app="semms" ng-init="get()">
    <div class="container-fluid p-3 bg-dark" style="overflow:auto; width:auto; height:10%">
        <div class="row">
            <ul class="nav nav-pills">
                <li class="nav-item my-auto">
                    <a class="nav-link" href="#!/main/counselor/dashboard"><h4 class="my-auto text-white">My Dasboard</h4></a>
                </li>                                         
            </ul>   
            <span class="col"></span>
            <button class="my-auto btn btn-primary mr-2" ng-click="go('main.cases')" title="All Cases"><i class="fas fa-search"></i> Cases <span class="badge badge-pill badge-light">{{caseCount}}</span></button>
            <button class="my-auto btn btn-info mr-3" ng-click="go('main.reports')" title="All Reports"><i class="fas fa-paperclip"></i> Reports <span class="badge badge-pill badge-light">{{reportCount}}</span></button>            
        </div>
    </div>
    <div class="container-fluid p-3" style="overflow:auto; height:90%">
        <div class="container-fluid bg-white card p-0">
            <div class="card-body p-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="my-auto">Notification Panel <span class="my-auto badge badge-pill badge-light">{{notificationCount}}</span></h5>
                </div>
                <div class="card-body p-0">
                    <table id="userTable" class="table table-sm table-bordered table-hover">
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
</div>