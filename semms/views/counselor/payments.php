<div class="container-fluid p-0 stylish-color" style="height:100%; overflow:hidden" ng-app="semms" ng-init="getPayment()">
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
                    <a class="nav-link" href="#!/main/counselor/payments"><h4 class="my-auto text-white"><u><strong>Payments</strong></u></h4></a>
                </li>                                            
            </ul>    
        </div>
    </div>
    <div id="content" class="container-fluid p-3" style="height:90%; overflow-y:auto; display:none">
        <!-- pending payment table -->
        <div class="container-fluid card p-0">
            <div class="card-header special-color-dark text-white">
                <div class="row p-0">
                    <h5 class="my-auto col"><strong>Pending Payments</strong> <span ng-if="pendingCount != 0" class="my-auto badge badge-pill badge-light">{{pendingCount}}</span></h5>
                </div>
            </div>
            <div class="card-body p-0">
                <table id="paymentTable1" class="table table-bordered table-hover" style="margin:0 !important">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Reference Case ID</th>
                            <th>Outstanding</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="payment in pendingList">
                            <td>{{$index+1}}</td>
                            <td>#{{payment.case_id}}</td>
                            <td>RM {{convertToCurrency(payment.outstanding)}}</td>
                            <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="openPaymentDetailsModal(payment.id, payment.case_id)" class="btn btn-primary btn-sm m-0"><i class="fas fa-info-circle"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- all payments table -->
        <div class="container-fluid card p-0 mt-3">
            <div class="card-header special-color-dark text-white">
                <div class="row p-0">
                    <h5 class="my-auto col"><strong>All Payments</strong> <span ng-if="paymentCount != 0" class="my-auto badge badge-pill badge-light">{{paymentCount}}</span></h5>
                </div>
            </div>
            <div class="card-body p-0" style="width:100%">
                <table id="paymentTable2" class="table table-bordered table-hover" style="margin:0 !important; width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Reference Case ID</th>
                            <th>Outstanding</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="payment in paymentList">
                            <td>{{$index+1}}</td>
                            <td>#{{payment.case_id}}</td>
                            <td >RM {{convertToCurrency(payment.outstanding)}}</td>
                            <td style="text-align:center"><button data-toggle="tooltip" title="More details" ng-click="openPaymentDetailsModal(payment.id, payment.case_id)" class="btn btn-primary btn-sm m-0"><i class="fas fa-info-circle"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>