<div class="container-fluid p-0 stylish-color" style="height:100%; overflow:hidden" ng-app="semms" ng-init="getDashboard()">
    <div class="container-fluid special-color-dark" style="height:10%">
        <div class="row" style="height:100%">
            <ul class="nav nav-pills">
                <li class="nav-item my-auto">
                    <a class="nav-link" href="#!/main/counselor/dashboard"><h4 class="my-auto text-white"><strong>My Dashboard</strong></h4></a>
                </li>                                         
            </ul>   
            <span class="col"></span>
            <button class="my-auto btn btn-white text-dark mr-2" ng-click="go('main.cases')" title="All Cases"><strong><i class="fas fa-search"></i> Cases <span class="badge badge-pill badge-dark">{{caseCount}}</span></strong></button>
            <button class="my-auto btn btn-white text-dark mr-2" ng-click="go('main.reports')" title="All Reports"><strong><i class="fas fa-paperclip"></i> Reports <span class="badge badge-pill badge-dark">{{reportCount}}</span></strong></button>            
            <button class="my-auto btn btn-white text-dark mr-3" ng-click="go('main.payments')" title="All Payments"><strong><i class="fas fa-money-bill-wave-alt"></i> Payments <span class="badge badge-pill badge-dark">{{paymentCount}}</span></strong></button>            
        </div>
    </div>
    <div  id="content" class="container-fluid p-3" style="height:90%; overflow-y:auto; display:none">
        <div class="container-fluid card p-0">
            <div class="card-header special-color-dark text-white">
                <div class="row p-0">
                    <h5 class="my-auto col"><strong>Notification Panel</strong> <span ng-if="unreadCount != 0" class="my-auto badge badge-pill badge-light">{{unreadCount}}</span></h5>
                    <input type="text" class="my-auto mr-3 form-control" ng-keyup="searchNotificationTable(text)" ng-model="text" style="width:25%" placeholder="Search notification....">
                </div>
                
            </div>
            <div class="card-body p-0" style="width:100%">
                <table id="notificationTable" class="table table-bordered table-hover" style="margin:0 !important; width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="notification in notificationList">
                            <td ng-class="{'font-weight-bold': notification.is_read == 'No', 'font-weight-normal': notification.is_read == 'Yes'}">{{$index+1}}</td>
                            <td ng-class="{'font-weight-bold': notification.is_read == 'No', 'font-weight-normal': notification.is_read == 'Yes'}">{{notification.subject}}</td>
                            <td ng-class="{'font-weight-bold': notification.is_read == 'No', 'font-weight-normal': notification.is_read == 'Yes'}">{{notification.date_triggered}}</td>
                            <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="openNotificationDetailsModal(notification)" class="btn btn-sm btn-primary m-0"><i class="fas fa-info-circle"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>