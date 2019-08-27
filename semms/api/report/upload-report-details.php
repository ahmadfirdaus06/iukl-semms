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
    
    $report->student_id = $data->student_id;
    $report->reporter_id = $data->reporter_id;
    $report->superior_id = $data->superior_id;
    $report->course_code = $data->course_code;
    $report->course_name = $data->course_name;
    $report->exam_venue = $data->exam_venue;
    $report->exam_date = $data->exam_date;
    $report->exam_time = $data->exam_time;
    $report->misconduct_time = $data->misconduct_time;
    $report->misconduct_description = $data->misconduct_description;
    $report->action_taken = $data->action_taken;
    $report->witness1_name = $data->witness1_name;
    $report->witness1_contact_no = $data->witness1_contact_no;
    $report->witness1_email = $data->witness1_email;
    $report->witness2_name = $data->witness2_name;
    $report->witness2_contact_no = $data->witness2_contact_no;
    $report->witness2_email = $data->witness2_email;

    $report_id = $report->create();

    if(!is_null($report_id)) {
        $misconduct_type = $data->misconduct_type;
        $conn = $db;
        $table = 'misconduct';
        $count = 0;
        $total = count($misconduct_type);

        foreach($misconduct_type as $type){
            $query = 'INSERT INTO ' . $table . ' SET 
            type = :type,
            report_id = :report_id';
            
            $stmt = $conn->prepare($query);

            $type = htmlspecialchars(strip_tags($type));

            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':report_id', $report_id);
            if($stmt->execute()) {
                $count++;
            }
            else{
                printf("Error: %s.\n", $stmt->error);
            }
        }

        if ($count == $total){
            echo json_encode(
            array(
                'message' => 'Success',
                'report_id' => $report_id)
            );
        }else{
            echo json_encode(
                array('message' => 'Failed')
            );
        }
    } 
    else {
        echo json_encode(
            array('message' => 'Failed')
        );
    }
?>
