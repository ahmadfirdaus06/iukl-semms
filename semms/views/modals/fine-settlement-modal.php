<!-- Fine Settlement Modal -->
<div class="modal-fade modal-header text-white bg-primary">
    <h4><strong>Fine Settlement</strong></h4>
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
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label><strong>Issued Fine Amount (RM)</strong></label>
                <input ng-model="stage.fine_amount" type="text" id="fine_amount" class="form-control" ng-readonly="stage.stage_status != 'Ongoing'" required/>
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
    <button class="btn btn-success" ng-click="" type="submit" ng-if="stage.stage_status == 'Ongoing'">
        <strong >Save and Proceed to Fine Settlement <i class="fas fa-arrow-right"></i> </strong>
    </button>
</div>
</form>
<script type="text/javascript">
    $('#fine_amount').keypress(function(event) {
        if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
                $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }else{
            var text = $(this).val();
            $(this).val((text.indexOf(".") >= 0) ? (text.substr(0, text.indexOf(".")) + text.substr(text.indexOf("."), 2)) : text);
        }
           
    }).on('paste', function(event) {
        event.preventDefault();
    });
</script>
