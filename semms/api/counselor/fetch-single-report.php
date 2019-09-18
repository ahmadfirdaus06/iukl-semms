<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../model/Student.php';
    include_once '../../model/Report.php';
    include_once '../../model/User.php';
    include_once '../../model/Attachment.php';
    include_once '../../model/Misconduct.php';

    $database = new Database();
    $db = $database->connect();
    $report = new Report($db);
    $attachment = new Attachment($db);
    $misconduct = new Misconduct($db);

    $data = json_decode(file_get_contents("php://input"));

    if (!is_null($data)){
        $report->report_id = $data->report_id;
        $attachment->report_id = $data->report_id;
        $misconduct->report_id = $data->report_id;

        $data_arr = array();
        $data_arr['message'] = 'Success';
        $data_arr['report'] = array();
        $data_arr['student'] = array();
        $data_arr['reporter'] = array();
        $data_arr['attachmentList'] = array();
        $data_arr['misconductList'] = array();

        //get report details + student + reporter
        $result = $report->readByReportId();
        if ($result){
            $num = $result->rowCount();
            if ($num > 0){
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $report_arr = array(
                        'report_id' => $report_id,
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
                        'report_status' => $report_status,
                    );

                    $student_arr = array(
                        'matric_id' => $matric_id,
                        'ic_or_passport' => $ic_or_passport,
                        'name' => $student_name,
                        'programme' => $programme,
                        'contact_no' => $student_contact_no,
                        'email' => $student_email,
                    );

                    $reporter_arr = array(
                        'staff_id' => $staff_id,
                        'name' => $reporter_name,
                        'email' => $reporter_email,
                        'contact_no' => $reporter_contact_no,
                    );

                    array_push($data_arr['report'], $report_arr);
                    array_push($data_arr['student'], $student_arr);
                    array_push($data_arr['reporter'], $reporter_arr);
                    
                }
            }
        }
        else{
            echo json_encode(
                array(
                    'message' => 'Failed'
                )
            );
        }

        //get attachment
        $result = $attachment->readByReportId();

        if ($result){
            $num = $result->rowCount();
            if ($num > 0){
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $arr = array(
                        'attachment_id' => $attachment_id,
                        'path' => $path,
                        'report_id' => $report_id
                    );
    
                    array_push($data_arr['attachmentList'], $arr);
                }
            }
        }
        else{
            echo json_encode(
                array(
                    'message' => 'Failed'
                )
            );
        }

        //get misconduct
        $result = $misconduct->readByReportId();

        if ($result){
            $num = $result->rowCount();
            if ($num > 0){
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $arr = array(
                        'misconduct_id' => $misconduct_id,
                        'type' => $type,
                        'report_id' => $report_id
                    );

                    array_push($data_arr['misconductList'], $arr);
                }
            }
        }
        else{
            echo json_encode(
                array(
                    'message' => 'Failed'
                )
            );
        }
        
        echo json_encode($data_arr);
        
    }
    else{
        echo json_encode(
            array(
                'message' => 'Failed'
            )
        );
    }

    

?>