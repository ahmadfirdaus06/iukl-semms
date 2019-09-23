<!-- Case Hearing Modal -->
<div class="modal-fade modal-header text-white bg-primary">
    <h4><strong>Case Hearing</strong></h4>
    <button type="button" class="close btn btn-link text-white" ng-click="close()">&times;</button>
</div>
<form ng-submit="proceed()">
<div class="modal-body" style="max-height:60vh; overflow-y:auto">
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
        <label><strong>Date of Case Hearing Session</strong></label>
        <input ng-model="stage.hearing_session_date" type="text" class="form-control datetimepicker-input" id="datepicker" data-target="#datepicker" data-toggle="datetimepicker" ng-readonly="stage.stage_status != 'Ongoing'" required/>
    </div>
    <div class="row">
        <div class=col-6>
            <div class="form-group">
                <label><strong>Start Hearing Session</strong></label>
                <input ng-model="stage.hearing_session_start" type="text" class="form-control datetimepicker-input" id="timepickerstart" data-target="#timepickerstart" data-toggle="datetimepicker" ng-readonly="stage.stage_status != 'Ongoing'" required/>
            </div>
        </div>
        <div class=col-6>
            <div class="form-group">
                <label><strong>End Hearing Session</strong></label>
                <input ng-model="stage.hearing_session_end" type="text" class="form-control datetimepicker-input" id="timepickerend" data-target="#timepickerend" data-toggle="datetimepicker" ng-readonly="stage.stage_status != 'Ongoing'" required/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label><strong>Notes/Remarks</strong></label>
        <textarea type="text" class="form-control" rows="5" ng-model="stage.notes_remarks" ng-readonly="stage.stage_status != 'Ongoing'" required></textarea>
    </div>
    <div style="display:none" id="proceedAlert" class="alert alert-danger" role="alert">
        Please fill the notes/remarks first to proceed!
    </div>
    <div class="form-group" ng-if="stage.stage_status != 'Ongoing'">
        <label><strong>Case Outcome</strong></label>
        <input type="text" class="form-control" ng-model="stage.result" readonly>
    </div>
    <div ng-if="stage.stage_status != 'Done'" class="form-group">
        <label><strong>Case Proceeding</strong></label>
        <select ng-disabled="stage.notes_remarks == ''" class="form-control" class="bootstrap-select" ng-model="stage.result" required>
            <option value="" selected="selected">--Please select--</option>
            <option value="Appeal">Case Appeal</option>
            <option value="Fine Settlement">Fine Settlement</option>
            <option value="Drop Case">Drop Case</option>
        </select>
    </div>
    <div ng-if="stage.notes_remarks == '' && stage.result == '' && stage.stage_status != 'Done'" class="alert alert-warning" role="alert">
        Please fill the notes/remarks first to proceed!
    </div>
</div>
<div class= "modal-footer">
    <button class="btn btn-danger" type="button" ng-click="close()">
        <strong><i class="fas fa-times"></i> Close</strong>
    </button>
    <button class="btn btn-success" ng-click="" type="submit" ng-if="stage.stage_status != 'Done'">
        <strong >Save and Proceed <i class="fas fa-arrow-right"></i> </strong>
    </button>
</div>
</form>
<script type="text/javascript">
    var datePicker = angular.element(document.querySelector('#datepicker'));
    
    datePicker.datetimepicker({
        format: 'L',
        format: 'YYYY/MM/DD'
    });

    var timePickerStart = angular.element(document.querySelector('#timepickerstart')); 
    var timePickerEnd = angular.element(document.querySelector('#timepickerend')); 

    timePickerStart.datetimepicker({
        format: 'LT',
        format: 'HH:mm'
    });
    timePickerEnd.datetimepicker({
        format: 'LT',
        format: 'HH:mm'
    });
</script>