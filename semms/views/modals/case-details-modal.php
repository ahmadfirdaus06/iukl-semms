<!-- Case Details Modal -->
<div id="modal" class="modal-header text-white bg-primary">
    <h4><strong>Case #{{case.case_id}} Details <i>(Status: {{case.case_status}}</i>)</strong></h4>
    <button type="button" class="close btn btn-link text-white" ng-click="later()">&times;</button>
</div>
			
<div class="modal-body" style="height:70vh; overflow-y:auto">
    <!-- <div class="form-group">
        <label><strong>1. STUDENT NAME</strong></label>
        <input type="text" class="form-control" ng-model="student.name" readonly>
    </div> -->
    
</div>
<div class= "modal-footer">
    <button class="btn btn-light" ng-if="report.report_status == 'Pending'" ng-click="later()">
        <strong><i class="far fa-clock"></i> Later</strong>
    </button>
    <button class="btn btn-danger" ng-if="report.report_status != 'Pending'" ng-click="later()">
        <strong><i class="fas fa-times"></i> Close</strong>
    </button>
    <button class="btn btn-success" ng-if="report.report_status == 'Pending'" ng-click="approve()">
        <strong><i class="fas fa-check"></i> Approve</strong>
    </button>
    <button class="btn btn-danger" ng-if="report.report_status == 'Pending'" ng-click="deny()">
        <strong><i class="fas fa-times"></i> Deny</strong>
    </button>
    <button class="btn btn-success" ng-click="" ng-if="report.report_status == 'Approved'">
        <strong >Go to case details <i class="fas fa-arrow-right"></i></strong>
    </button>
</div>