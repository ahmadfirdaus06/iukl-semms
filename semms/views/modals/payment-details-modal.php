<!-- Payment Details Modal -->
<div class="modal-fade modal-header text-white bg-primary">
    <h4><strong>Fine Payment Information for Case #{{paymentDetails.case_id}}</strong></h4>
    <button type="button" class="close btn btn-link text-white" ng-click="close()">&times;</button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label><strong>Payment Status</strong></label>
        <input type="text" class="form-control" ng-model="paymentDetails.payment_status" readonly>
    </div>
    <div class="form-group">
        <label><strong>Outstanding</strong></label>
        <input type="text" class="form-control" ng-model="paymentDetails.outstanding" readonly/>
    </div>
    <div class="form-group">
        <label><strong>Last Paid</strong></label>
        <input type="text" class="form-control" ng-model="paymentDetails.last_paid" readonly>
    </div>
</div>
<div class= "modal-footer">
    <button class="btn btn-danger" ng-click="close()"><strong><i class="fas fa-times"></i> Close</strong></button>
</div>