<div class="container-fluid p-0 stylish-color" style="height:100%; overflow:hidden" ng-app="semms" ng-init="getCase()">
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
                    <a class="nav-link" href="#!/main/counselor/cases"><h4 class="my-auto text-white"><u><strong>Cases</strong></u></h4></a>
                </li>                                            
            </ul>    
        </div>
    </div>
    <div id="content" class="container-fluid p-3" style="height:90%; overflow-y:auto; display:none">
        <!-- ongoing case table -->
        <div class="container-fluid card p-0">
            <div class="card-header special-color-dark text-white">
                <div class="row p-0">
                    <h5 class="my-auto col"><strong>Ongoing Cases</strong> <span ng-if="ongoingCount != 0" class="my-auto badge badge-pill badge-light">{{ongoingCount}}</span></h5>
                    <input type="text" class="my-auto mr-3 form-control border border-secondary" ng-keyup="searchCaseTable1(text1)" ng-model="text1" style="width:25%" placeholder="Search ongoing case....">
                </div>
            </div>
            <div class="card-body p-0" style="width:100%">
                <table id="caseTable1" class="table table-bordered table-hover" style="margin:0 !important; width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Case ID</th>
                            <th>Reference Report</th>
                            <th>Date Started</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="case in ongoingList">
                            <td>{{$index+1}}</td>
                            <td>#{{case.id}}</td>
                            <td>#{{case.report_id}}</td>
                            <td>{{case.created_date}}</td>
                            <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="go('main.case-details', case.report_id)" class="btn btn-primary btn-sm m-0"><i class="fas fa-info-circle"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- all cases table -->
        <div class="container-fluid card p-0 mt-3">
            <div class="card-header special-color-dark text-white">
                <div class="row p-0">
                    <h5 class="my-auto col"><strong>All Cases</strong> <span ng-if="caseCount != 0" class="my-auto badge badge-pill badge-light">{{caseCount}}</span></h5>
                    <input type="text" class="my-auto mr-3 form-control border border-secondary" ng-keyup="searchCaseTable2(text2)" ng-model="text2" style="width:25%" placeholder="Search case....">
                </div>
            </div>
            <div class="card-body p-0" style="width:100%">
                <table id="caseTable2" class="table table-bordered table-hover" style="margin:0 !important; width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Case ID</th>
                            <th>Reference Report</th>
                            <th>Date Started</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="case in caseList">
                            <td>{{$index+1}}</td>
                            <td>#{{case.id}}</td>
                            <td>#{{case.report_id}}</td>
                            <td>{{case.created_date}}</td>
                            <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="go('main.case-details', case.report_id)" class="btn btn-primary btn-sm m-0"><i class="fas fa-info-circle"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>