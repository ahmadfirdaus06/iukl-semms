<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../model/Report.php';

    $database = new Database();
    $db = $database->connect();
    $report = new Report($db);

    $data_arr = array();
    $data_arr['reportList'] = array();
    $data_arr['pendingList'] = array();
    $data_arr['message'] = '';
    $result = $report->readAll();
    if ($result){
        $num = $result->rowCount();
        if ($num > 0){
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $arr = array(
                    'report_id' => $report_id,
                        'student_id' => $student_id,
                        'reporter_id' => $reporter_id,
                        'superior_id' => $superior_id,
                        'course_code' => $course_code,
                        'course_name' => $course_name,
                        'exam_venue' => $exam_venue,
                        'exam_date' => $exam_date,
                        'exam_time' => $exam_time,
                        'misconduct_time' => $misconduct_time,
                        'misconduct_description' => $misconduct_description,
                        'action_taken' => $action_taken,
                        'witness1_name' => $witness1_name,
                        'witness1_contact_no' => $witness1_contact_no,
                        'witness1_email' => $witness1_email,
                        'witness2_name' => $witness2_name,
                        'witness2_contact_no' => $witness2_contact_no,
                        'witness2_email' => $witness2_email,
                        'uploaded_by' => $uploaded_by,
                        'last_approval_date' => $last_approval_date,
                        'is_valid' => $is_valid,
                        'case_status' => $case_status,
                        'report_status' => $report_status
                );
                array_push($data_arr['reportList'], $arr);
                if ($report_status == 'Pending'){
                    array_push($data_arr['pendingList'], $arr);
                }
            }
        }
        $data_arr['message'] = 'Success';
            echo json_encode($data_arr);
        
    }
    else{
        echo json_encode(
            array('message' => 'Failed')
        );
    }
    

    

?>