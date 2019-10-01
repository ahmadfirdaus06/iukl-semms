<div class="container-fluid p-0 stylish-color" style="height:100%; overflow:hidden" ng-app="semms" ng-init="getCaseDetails()">
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
                    <a class="nav-link" href="#!/main/counselor/cases"><h4 class="my-auto text-white"><strong>Cases</strong></h4></a>
                </li>
                <li class="nav-item my-auto">
                    <a class="nav-link"><h4 class="my-auto text-white"><span><i class="fas fa-chevron-right"></i></span></h4></a>
                </li>     
                <li class="nav-item my-auto">
                    <a class="nav-link" href="#!/main/counselor/cases/case-details?id={{caseDetails.report_id}}"><h4 class="my-auto text-white"><u><small>Case #{{caseDetails.case_id}}</small></u></h4></a>
                </li>                                            
            </ul>    
        </div>
    </div>
    <div id="content" class="container-fluid p-3 text-light" style="height:90%; overflow-y:auto; display:none">
        <div class="row px-3">
            <div class="card p-0 col special-color-dark text-white">
                <div class="card-header" style="border-bottom-style: solid; border-color:#FFFFFF; border-width: 2">
                    <div class="row p-0">
                        <h5 class="my-auto col"><strong>Case information</strong></h5>
                    </div>
                </div>
                <div class="card-body special-dark-color">
                    <div class="row">
                        <div class="col">
                            <div class="card stylish-color">
                                <div class="card-header"><strong>Case Id</strong></div>
                                <div class="card-body">
                                    <label><h4>#{{caseDetails.case_id}}</h4></label>
                                </div>
                            </div>
                            <br>
                            <div class="card stylish-color">
                                <div class="card-header"><strong>Created on</strong></div>
                                <div class="card-body">
                                    <label><h4>{{caseDetails.created_date}}</h4></label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card stylish-color">
                                <div class="card-header"><strong>Reference Report ID</strong></div>
                                <div class="card-body">
                                    <label><h4>#{{caseDetails.report_id}}</h4></label>
                                </div>
                                <div class="card-footer p-0">
                                    <button style="margin:0 auto; float:none" class="btn btn-sm btn-block btn-primary" ng-click="openReportDetailsModal(caseDetails)"><strong>View</strong></button>
                                </div>
                            </div>
                            <br>
                            <div ng-if="paymentDetails.payment_status != null" class="card stylish-color">
                                <div class="card-header"><strong>Fine Payment Status</strong></div>
                                <div class="card-body">
                                    <label><h4>{{paymentDetails.payment_status}}</h4></label>
                                </div>
                                <div class="card-footer p-0">
                                    <button style="margin:0 auto; float:none" class="btn btn-sm btn-block btn-primary" ng-click="openPaymentDetailsModal(paymentDetails.payment_id, caseDetails.case_id)"><strong>View</strong></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <span class="m-3"></span>
            <div class="wrapper">
                <div class="card p-0 col special-color-dark text-white" style="height:auto">
                    <div class="card-header" style="border-bottom-style: solid; border-color:#FFFFFF; border-width: 2">
                        <div class="row p-0">
                            <h5 class="my-auto col"><strong>Case Tracking Details</strong></h5>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table id="caseHistoryTable" class="table table-borderless text-white" style="margin:0 !important">
                            <tr ng-repeat="stage in caseHistoryList" ng-if="stage.status != 'Done'" style="border-bottom-style: solid; border-color:#FFFFFF; borderborder-width: 2" class="stylish-color">
                                <td class="font-weight-bold">Stage {{$index+1}}<br>(Current)</td>
                                <td class="font-weight-bold">{{stage.type}}</td>
                                <td class="font-weight-normal">(last updated on {{stage.last_updated}})</td>
                                <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="openStageDetails(stage.stage_id, stage.type)" class="btn btn-primary btn-sm m-0"><i class="fas fa-info-circle"></i></button></td>
                            </tr>
                            <tr ng-repeat="stage in caseHistoryList" ng-if="stage.status == 'Done'">
                                <td class="font-weight-bold">Stage {{$index+1}}</td>
                                <td class="font-weight-bold">{{stage.type}}</td>
                                <td class="font-weight-normal">(closed on {{stage.last_updated}})</td>
                                <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="openStageDetails(stage.stage_id, stage.type)" class="btn btn-primary btn-sm m-0"><i class="fas fa-info-circle"></i></button></td>
                            </tr>
                        </table>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>
