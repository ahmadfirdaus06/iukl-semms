<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/Report.php';

    $database = new Database();
    $db = $database->connect();

    $report = new Report($db);

    $data = json_decode(file_get_contents("php://input"));

    extract($data);
    
    $report->student_id = 'studentId';
    $report->reporter_id = 'reporterId';
    $report->superior_id = 'superiorId';
    $report->course_code = 'courseCode';
    $report->course_name = 'courseName';
    $report->exam_venue = 'examVenue';
    $report->exam_date = 'examDate';
    $report->exam_time = 'examTime';
    $report->misconduct_time = 'misconductTime';
    $report->misconduct_description = 'misconductDescription';
    $report->action_taken = 'actionTaken';
    $report->witness1_name = 'witness1Name';
    $report->witness1_contact_no = 'witness1ContactNo';
    $report->witness1_email = 'witness1Email';
    $report->witness2_name = 'witness2Name';
    $report->witness2_contact_no = 'witness2ContactNo';
    $report->witness2_email = 'witness2Email';

    if(!is_null($report->create())) {
        $report_id = $report->create();
        echo json_encode(
            array(
                'message' => 'Success',
                'report_id' => $report_id)
        );
    } 
    else {
        echo json_encode(
            array('message' => 'Failed')
        );
    }
?>
