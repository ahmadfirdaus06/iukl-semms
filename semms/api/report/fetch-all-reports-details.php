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
    $student = new Student($db);
    $report = new Report($db);
    $user = new User($db);
    $attachment = new Attachment($db);
    $misconduct = new Misconduct($db);

    $data = json_decode(file_get_contents("php://input"));

    $report->reporter_id = $data->user_id;

    $data_arr = array();
    $data_arr['studentList'] = array();
    $data_arr['reportList'] = array();
    $data_arr['userList'] = array();
    $data_arr['attachmentList'] = array();
    $data_arr['misconductList'] = array();

    //get student
    $result = $student->readAll();
    $num = $result->rowCount();
    if ($num > 0){
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $arr = array(
                'student_id' => $student_id,
                'matric_id' => $matric_id,
                'ic_or_passport' => $ic_or_passport,
                'name' => $name,
                'programme' => $programme,
                'contact_no' => $contact_no,
                'email' => $email
            );

            array_push($data_arr['studentList'], $arr);
        }
    }

    //get report
    $result = $report->readByReporterId();
    $num = $result->rowCount();
    if ($num > 0){
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $arr = array(
                'report_id' => $report_id,
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
                'last_approval_date' => $last_approval_date
            );

            array_push($data_arr['reportList'], $arr);
        }
    }

    //get user
    $result = $user->readAllAnon();
    $num = $result->rowCount();
    if ($num > 0){
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $arr = array(
                'user_id' => $user_id,
                'staff_id' => $staff_id,
                'password' => $password,
                'name' => $name,
                'email' => $email,
                'contact_no' => $contact_no,
                'user_type' => $user_type,
                'created_date' => $created_date,
                'modified_date' => $modified_date,
                'last_login' => $last_login,
                'granted_access' => $granted_access
            );

            array_push($data_arr['userList'], $arr);
        }
    }

    //get attachment
    $result = $attachment->readAll();
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

    //get misconduct
    $result = $misconduct->readAll();
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

?>