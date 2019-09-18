<!-- Loading Modal -->
<div class="modal" id="loadingModal" data-backdrop="static" data-keyboard="false" show="false">
    <div class="modal-dialog modal-sm modal-dialog-centered" >
		<div class="modal-content">
            <div class="modal-body text-center">
                <div class="row text-dark justify-content-center">
                    <div class="spinner-border spinner-border-sm my-auto"></div>
                    <span class="ml-3 my-auto">Loading....</span>
                </div>
            </div>
		</div>
	</div>
</div>
<!-- Report Details Modal -->
<div class="modal fade" id="reportDetailsModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" >
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4><strong>Report #{{report.report_id}} Details</strong></h4>
				<button type="button" class="close btn btn-link text-white" data-dismiss="modal">&times;</button>
			</div>
			<form>
				<div class="modal-body" style="height:70vh; overflow-y:auto">
                    <div class="form-group">
                        <label><strong>1. STUDENT NAME</strong></label>
                        <input type="text" class="form-control" ng-model="student.name" readonly>
                    </div>
                    <div class="form-group">
                        <label><strong>2. ID NO</strong></label>
                        <input type="text" class="form-control" ng-model="student.matric_id" readonly>
                    </div>
                    <div class="form-group">
                        <label><strong>3. COURSE CODE</strong></label>
                        <input type="text" class="form-control" ng-model="report.course_code" readonly>
                    </div>
                    <div class="form-group">
                        <label><strong>4. COURSE NAME</strong></label>
                        <input type="text" class="form-control" ng-model="report.course_name" readonly>
                    </div>
                    <div class="form-group">
                        <label><strong>5. PROGRAMME</strong></label>
                        <input type="text" class="form-control" ng-model="student.programme" readonly>
                    </div>
                    <div class="form-group">
                        <label><strong>6. H/P NO</strong></label>
                        <input type="text" class="form-control" ng-model="student.contact_no" readonly>
                    </div>
                    <div class="form-group">
                        <label><strong>7. EMAIL</strong></label>
                        <input type="text" class="form-control" ng-model="student.email" readonly>
                    </div>
                    <div class="form-group">
                        <label><strong>8. I/C OR PASSPORT</strong></label>
                        <input type="text" class="form-control" ng-model="student.ic_or_passport" readonly>
                    </div>
                    <div class="form-group">
                        <label><strong>9. DATE OF EXAM</strong></label>
                        <input type="text" class="form-control" ng-model="report.exam_date" readonly>
                    </div>
                    <div class="form-group">
                        <label><strong>10. TIME OF EXAM</strong></label>
                        <input type="text" class="form-control" ng-model="report.exam_time" readonly>
                    </div>
                    <div class="form-group">
                        <label><strong>11. VENUE OF EXAM</strong></label>
                        <input type="text" class="form-control" ng-model="report.exam_venue" readonly>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label><strong>12. REPORT</strong></label>
                        <br>
                        <label><strong>i. Type of Misconduct:</strong></label>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr ng-repeat="misconduct in misconductList">
                                    <td style="width:5%">{{$index+1}}.</td>
                                    <td>{{misconduct.type}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <label><strong>ii. Time of Misconduct:</strong></label>
                        <input type="text" class="form-control" ng-model="report.misconduct_time" readonly>
                        <br>
                        <label><strong>iii. Detail/Description of Misconduct:</strong></label>
                        <textarea type="text" class="form-control" ng-model="report.misconduct_description" readonly></textarea>
                        <br>
                        <label><strong>iv. Action Taken:</strong></label>
                        <textarea type="text" class="form-control" ng-model="report.action_taken" readonly></textarea>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label><strong>13. ATTACHMENTS:</strong></label>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr ng-repeat="attachment in attachmentList">
                                    <td style="width:5%">{{$index+1}}.</td>
                                    <td><a href="http://semms.ddns.net:8080/semms-uploads/{{attachment.path}}" target="_blank">Attachment {{$index+1}}</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <label><strong>i. Reported By</strong></label>
                        <br>
                        <label><strong>Reporter's Name:</strong></label>
                        <input type="text" class="form-control" ng-model="reporter.name" readonly>
                        <br>
                        <label><strong>Reporter's H/P No:</strong></label>
                        <input type="text" class="form-control" ng-model="reporter.contact_no" readonly>
                        <br>
                        <label><strong>Reporter's Email:</strong></label>
                        <input type="text" class="form-control" ng-model="reporter.email" readonly>
                        <br>
                        <label><strong>ii. Witness 1</strong></label>
                        <br>
                        <label><strong>Witness 1's Name:</strong></label>
                        <input type="text" class="form-control" ng-model="report.witness1_name" readonly>
                        <br>
                        <label><strong>Witness 1's H/P No:</strong></label>
                        <input type="text" class="form-control" ng-model="report.witness1_contact_no" readonly>
                        <br>
                        <label><strong>Witness 1's Email:</strong></label>
                        <input type="text" class="form-control" ng-model="report.witness1_email" readonly>
                        <br>
                        <label><strong>iii. Witness 2</strong></label>
                        <br>
                        <label><strong>Witness 2's Name:</strong></label>
                        <input type="text" class="form-control" ng-model="report.witness2_name" readonly>
                        <br>
                        <label><strong>Witness 2's H/P No:</strong></label>
                        <input type="text" class="form-control" ng-model="report.witness2_contact_no" readonly>
                        <br>
                        <label><strong>Witness 2's Email:</strong></label>
                        <input type="text" class="form-control" ng-model="report.witness2_email" readonly>
                    </div>
                </div>
				<div class= "modal-footer">
					<button class="btn btn-warning" data-dismiss="modal">
                        <strong><i class="far fa-clock"></i> Later</strong>
                    </button>
                    <button class="btn btn-success" ng-click="">
                        <strong><i class="fas fa-check"></i> Approve</strong>
                    </button>
                    <button class="btn btn-danger" ng-click="">
                        <strong><i class="fas fa-times"></i> Deny</strong>
                    </button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Notification Details Modal -->
<div class="modal fade" id="notificationDetailsModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal modal-dialog-centered" >
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4><strong>Notification Details</strong></h4>
				<button type="button" class="close btn btn-link text-white" ng-click="closeNotificationDetailsModal()">&times;</button>
			</div>
			<form>
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
					<button class="btn btn-danger" ng-click="closeNotificationDetailsModal()"><strong><i class="fas fa-times"></i> Close</strong></button>
                    <button class="btn btn-success" ng-click="openReportDetails(notification)" ng-if="notification.tag == 'report'">
                        <strong >Go to report details <i class="fas fa-arrow-right"></i></strong>
                    </button>
                    <button class="btn btn-success" ng-click="" ng-if="notification.tag == 'payment'">
                        <strong >Go to payment details <i class="fas fa-arrow-right"></i></strong>
                    </button>
				</div>
			</form>
		</div>
	</div>
</div>