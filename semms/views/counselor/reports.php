<div class="container-fluid p-0 bg-secondary" style="height:100%; overflow:hidden" ng-app="semms" ng-init="getReport()">
    <div class="container-fluid bg-dark" style="height:10%">
        <div class="row" style="height:100%">
            <ul class="nav nav-pills">
                <li class="nav-item my-auto">
                        <a class="nav-link" href="#!/main/counselor/dashboard"><h4 class="my-auto text-white">My Dashboard</h4></a>
                </li>
                <li class="nav-item my-auto">
                    <a class="nav-link"><h4 class="my-auto text-white"><span><i class="fas fa-chevron-right"></i></span></h4></a>
                </li>     
                <li class="nav-item my-auto">
                    <a class="nav-link" href="#!/main/counselor/reports"><h4 class="my-auto text-white"><u>Reports</u></h4></a>
                </li>                                            
            </ul>    
        </div>
    </div>
    <div id="content" class="container-fluid p-3 bg-secondary" style="height:90%; overflow-y:auto">
        <!-- pending report table -->
        <div class="container-fluid bg-white card p-0">
            <div class="card-body p-0">
                <div class="card-header bg-primary text-white">
                    <div class="row p-0">
                        <h5 class="my-auto col">Awaiting Your Approval <span class="my-auto badge badge-pill badge-light">{{unreadCount}}</span></h5>
                    </div>
                    
                </div>
                <div class="card-body p-0">
                    <table id="reportTable1" ng-if="pendingList" class="table table table-bordered table-hover">
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
                                <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="openReportDetailsModal(report)" class="btn btn-primary"><i class="fas fa-info-circle"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- all reports table -->
        <div class="container-fluid bg-white card p-0 mt-3">
            <div class="card-body p-0">
                <div class="card-header bg-primary text-white">
                    <div class="row p-0">
                        <h5 class="my-auto col">All Reports <span class="my-auto badge badge-pill badge-light">{{reportCount}}</span></h5>
                        <input type="text" class="my-auto mr-3 form-control border border-secondary" ng-keyup="searchReportTable(text)" ng-model="text" style="width:25%" placeholder="Search report....">
                    </div>
                    
                </div>
                <div class="card-body p-0">
                    <table id="reportTable2" ng-if="reportList" class="table table-bordered table-hover">
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
                                <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="openReportDetailsModal(report)" class="btn btn-primary"><i class="fas fa-info-circle"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>