<!-- Case Appeal Modal -->
<div class="modal-fade modal-header text-white bg-primary">
    <h4><strong>Case Appeal</strong></h4>
    <button type="button" class="close btn btn-link text-white" ng-click="close()">&times;</button>
</div>
<form ng-submit="proceed()">
<div class="modal-body" style="max-height:70vh; overflow-y:auto">
    <div class="row">
        <div class=col-6>
            <div class="form-group">
                <label><strong>Case ID</strong></label>
                <input type="text" class="form-control" ng-model="stage.case_id" readonly>
            </div>
        </div>
        <div class=col-6>
            <div class="form-group">
                <label><strong>Current Status</strong></label>
                <input type="text" class="form-control" ng-model="stage.stage_status" readonly>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label><strong>Student Appeal Details</strong></label>
        <textarea ng-model="stage.student_appeal_request_details" rows="5" type="text" class="form-control" ng-readonly="stage.stage_status != 'Ongoing'" required></textarea>
    </div>
    <div class="row">
        <div class=col-6>
            <div class="form-group">
                <label><strong>Appeal Submitted Date</strong></label>
                <input ng-model="stage.appeal_submitted_date" type="text" class="form-control datetimepicker-input" id="datepicker" data-target="#datepicker" data-toggle="datetimepicker" ng-readonly="stage.stage_status != 'Ongoing'" required/>
            </div>
        </div>
        <div class=col-6>
            <div class="form-group">
                <label><strong>Appeal Request Status</strong></label>
                <select ng-readonly="stage.stage_status != 'Ongoing'" class="form-control" class="bootstrap-select" ng-model="stage.request_status" required>
                    <option value="" selected="selected">--Please select--</option>
                    <option value="Accepted">Accept</option>
                    <option value="Denied">Deny</option>
                    <option value="Considered">Consider</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label><strong>Notes/Remarks</strong></label>
        <textarea type="text" class="form-control" rows="5" ng-model="stage.notes_remarks" ng-readonly="stage.stage_status != 'Ongoing'" required></textarea>
    </div>
    <div class="form-group" ng-if="stage.stage_status != 'Ongoing'">
        <label><strong>Case Outcome</strong></label>
        <input type="text" class="form-control" ng-model="stage.result" readonly>
    </div>
</div>
<div class= "modal-footer">
    <button class="btn btn-danger" type="button" ng-click="close()">
        <strong><i class="fas fa-times"></i> Close</strong>
    </button>
    <button class="btn btn-success" ng-click="" type="submit" ng-if="stage.stage_status != 'Done'">
        <strong >Save and Proceed to Fine Settlement <i class="fas fa-arrow-right"></i> </strong>
    </button>
</div>
</form>
<script type="text/javascript">
    var datePicker = angular.element(document.querySelector('#datepicker'));
    
    datePicker.datetimepicker({
        format: 'L',
        format: 'YYYY/MM/DD'
    });
</script>