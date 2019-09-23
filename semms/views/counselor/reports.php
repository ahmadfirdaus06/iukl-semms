<div class="container-fluid p-0 stylish-color" style="height:100%; overflow:hidden" ng-app="semms" ng-init="getReport()">
    <div class="container-fluid special-color-dark" style="height:10%">
        <div class="row" style="height:100%">
            <ul class="nav nav-pills">
                <li class="nav-item my-auto">
                        <a class="nav-link" href="#!/main/counselor/dashboard"><h4 class="my-auto text-white"><strong>My Dashboard</strong></h4></a>
                </li>
                <li class="nav-item my-auto">
                    <a class="nav-link"><h4 class="my-auto text-white"><span><i class="fas fa-chevron-right"></i></span></h4></a>
                </li>     
                <li class="nav-item my-auto">
                    <a class="nav-link" href="#!/main/counselor/reports"><h4 class="my-auto text-white"><u><strong>Reports</strong></u></h4></a>
                </li>                                            
            </ul>    
        </div>
    </div>
    <div id="content" class="container-fluid p-3" style="height:90%; overflow-y:auto; display:none">
        <!-- pending report table -->
        <div class="container-fluid card p-0">
            <div class="card-header special-color-dark text-white">
                <div class="row p-0">
                    <h5 class="my-auto col"><strong>Awaiting Your Approval</strong> <span ng-if="unreadCount != 0" class="my-auto badge badge-pill badge-light">{{unreadCount}}</span></h5>
                </div>
            </div>
            <div class="card-body p-0" style="width:100%">
                <table id="reportTable1" class="table table-bordered table-hover" style="margin:0 !important; width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Report ID</th>
                            <th>Description</th>
                            <th>Date Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="report in pendingList" ng-if="report.report_status == 'Pending'">
                            <td>{{$index+1}}</td>
                            <td>#{{report.report_id}}</td>
                            <td>{{report.misconduct_description}}</td>
                            <td>{{report.uploaded_by}}</td>
                            <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="openReportDetailsModal(report)" class="btn btn-primary btn-sm m-0"><i class="fas fa-info-circle"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- all reports table -->
        <div class="container-fluid card p-0 mt-3">
            <div class="card-header special-color-dark text-white">
                <div class="row p-0">
                    <h5 class="my-auto col"><strong>All Reports</strong> <span ng-if="reportCount != 0" class="my-auto badge badge-pill badge-light">{{reportCount}}</span></h5>
                    <input type="text" class="my-auto mr-3 form-control border border-secondary" ng-keyup="searchReportTable(text)" ng-model="text" style="width:25%" placeholder="Search report....">
                </div>
                
            </div>
            <div class="card-body p-0" style="width:100%">
                <table id="reportTable2" class="table table-bordered table-hover" style="margin:0 !important; width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Report ID</th>
                            <th>Description</th>
                            <th>Date Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="report in reportList" ng-class="{'font-weight-bold': status == report.report_status, 'font-weight-normal': status != report.report_status}" ng-if="status = 'Pending'">
                            <td>{{$index+1}}</td>
                            <td>#{{report.report_id}}</td>
                            <td>{{report.misconduct_description}}</td>
                            <td>{{report.uploaded_by}}</td>
                            <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="openReportDetailsModal(report)" class="btn btn-primary btn-sm m-0"><i class="fas fa-info-circle"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>