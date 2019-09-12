<div id="content" class="container-fluid p-0 h-100 bg-secondary" style="height:100%" ng-app="semms" ng-init="get(); initDOM()">
    <div class="container-fluid bg-dark" style="height:10%">
        <div class="row" style="height:100%">
            <ul class="nav nav-pills">
                <li class="nav-item my-auto">
                    <a class="nav-link" href="#!/main/counselor/dashboard"><h4 class="my-auto text-white">My Dashboard</h4></a>
                </li>                                         
            </ul>   
            <span class="col"></span>
            <button class="my-auto btn btn-primary mr-2" ng-click="" title="All Cases"><i class="fas fa-search"></i> Cases <span class="badge badge-pill badge-light">{{caseCount}}</span></button>
            <button class="my-auto btn text-white btn-warning mr-2" ng-click="" title="All Reports"><i class="fas fa-paperclip"></i> Reports <span class="badge badge-pill badge-light">{{reportCount}}</span></button>            
            <button class="my-auto btn btn-success mr-3" ng-click="" title="All Payments"><i class="fas fa-money-bill-wave-alt"></i> Payments <span class="badge badge-pill badge-light">{{paymentCount}}</span></button>            
        </div>
    </div>
    <div class="container-fluid p-3" style="height:85%">
        <div class="container-fluid bg-white card p-0">
            <div class="card-body p-0">
                <div class="card-header bg-primary text-white">
                    <div class="row p-0">
                        <h5 class="my-auto col">Notification Panel <span class="my-auto badge badge-pill badge-light">{{unreadCount}}</span></h5>
                        <input type="text" class="my-auto mr-3 form-control border border-secondary" ng-keyup="searchTable(text)" ng-model="text" style="width:25%" placeholder="Search notification....">
                    </div>
                    
                </div>
                <div class="card-body p-0">
                    <table id="notificationTable" class="table table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="notification in notificationList" ng-class="{'font-weight-bold': read == notification.is_read, 'font-weight-normal': read != notification.is_read}" ng-if="read = 'No'">
                                <td>{{$index+1}}</td>
                                <td>{{notification.subject}}</td>
                                <td>{{notification.date_triggered}}</td>
                                <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="" class="btn btn-primary"><i class="fas fa-info-circle"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>