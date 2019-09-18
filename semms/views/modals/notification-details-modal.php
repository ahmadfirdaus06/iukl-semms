<!-- Notification Details Modal -->
<div class="modal-fade modal-header text-white bg-primary">
    <h4><strong>Notification Details</strong></h4>
    <button type="button" class="close btn btn-link text-white" ng-click="close()">&times;</button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label><strong>Subject</strong></label>
        <input type="text" class="form-control" ng-model="notification.subject" readonly>
    </div>
    <div class="form-group">
        <label><strong>Description</strong></label>
        <textarea type="text" class="form-control" ng-model="notification.description" readonly></textarea>
    </div>
    <div class="form-group">
        <label><strong>Received on</strong></label>
        <input type="text" class="form-control" ng-model="notification.date_triggered" readonly>
    </div>
</div>
<div class= "modal-footer">
    <button class="btn btn-danger" ng-click="close()"><strong><i class="fas fa-times"></i> Close</strong></button>
    <button class="btn btn-success" ng-click="openReportDetails()" ng-if="notification.tag == 'report'">
        <strong >Go to report details <i class="fas fa-arrow-right"></i></strong>
    </button>
    <button class="btn btn-success" ng-click="" ng-if="notification.tag == 'payment'">
        <strong >Go to payment details <i class="fas fa-arrow-right"></i></strong>
    </button>
</div>