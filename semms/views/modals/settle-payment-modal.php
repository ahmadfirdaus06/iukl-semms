<!-- Settle Payment Modal -->
<div class="modal-fade modal-header text-white bg-primary">
    <h4><strong>Payment for Case #{{paymentDetails.case_id}} <small><span ng-class="{'badge-success': paymentDetails.payment_status == 'Paid', 'badge-light': paymentDetails.payment_status == 'Pending'}" class="my-auto badge">{{paymentDetails.payment_status}}</span></small></strong></h4>
    <button type="button" class="close btn btn-link text-white" ng-click="close()">&times;</button>
</div>
<form ng-submit="pay()">
<div class="modal-body" style="max-height:60vh; overflow-y:auto">
    <div class="form-group">
        <label><strong>Student Matric ID</strong></label>
        <input type="text" class="form-control" ng-model="paymentDetails.student_id" readonly>
    </div>
    <div class="form-group">
        <label><strong>Student Name</strong></label>
        <input type="text" class="form-control" ng-model="paymentDetails.student_name" readonly>
    </div>
    <div class="form-group">
        <label><strong>Issued Date</strong></label>
        <input type="text" class="form-control" ng-model="paymentDetails.date_issued" readonly>
    </div>
    <div class="form-group">
        <label><strong>Issued Fine Amount (RM)</strong></label>
        <input type="text" class="form-control" ng-model="paymentDetails.issued_amount" readonly>
    </div>
    <div class="form-group">
        <label><strong>Outstanding (RM)</strong></label>
        <input id="outstanding" type="text" class="form-control" ng-model="paymentDetails.outstanding" readonly>
    </div>
    <div ng-if="paymentDetails.payment_status == 'Paid'" class="form-group">
        <label><strong>Last Complete Payment</strong></label>
        <input id="outstanding" type="text" class="form-control" ng-model="paymentDetails.last_paid" readonly>
    </div>
    <div ng-show="paymentDetails.payment_status == 'Pending'" class="form-group">
        <label><strong>Amount to be paid (RM)</strong></label>
        <input id="pay_amount" type="text" class="form-control" ng-model="paymentDetails.paid_amount" required>
    </div>
</div>
<div class= "modal-footer">
    <button class="btn btn-danger" type="button" ng-click="close()"><strong><i class="fas fa-times"></i> Close</strong></button>
    <button class="btn btn-success" type="submit" ng-if="paymentDetails.payment_status == 'Pending'"><strong><i class="fas fa-check"></i> Pay</strong></button>
</div>
</form>
<script type="text/javascript">
    $('#pay_amount').keypress(function(event) {
        if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
                $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }else{
            var text = $(this).val();
            $(this).val((text.indexOf(".") >= 0) ? (text.substr(0, text.indexOf(".")) + text.substr(text.indexOf("."), 2)) : text);
            
            if ($(this).val() > parseFloat($('#outstanding').val() - 1)){
                event.preventDefault();
                $(this).val($('#outstanding').val());
            }
        }
           
    }).on('paste', function(event) {
        event.preventDefault();
    });
</script>