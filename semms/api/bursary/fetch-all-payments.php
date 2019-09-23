<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/BeanConfig.php';

    $data_arr = array();
    $data_arr['paymentList'] = array();
    $data_arr['pendingList'] = array();
    $data_arr['message'] = "Success"; 

    try{
        $result = R::getAll("
        SELECT 
        payment.id AS payment_id,
        payment.case_id,
        payment.payment_status,
        cases.report_id,
        student.matric_id AS student_id,
        student.name AS student_name,
        stagehistory.last_updated AS date_issued
        FROM payment
        INNER JOIN cases
        ON payment.case_id = cases.id
        INNER JOIN report 
        ON cases.report_id = report.report_id
        INNER JOIN student
        ON report.student_id = student.student_id
        INNER JOIN stagehistory
        ON cases.id = stagehistory.case_id
        WHERE stagehistory.type = 'Fine Settlement'
        ");

        foreach($result as $item){
            $item = json_decode(json_encode($item));
            $arr = array(
                'payment_id' => $item->payment_id,
                'case_id' => $item->case_id,
                'payment_status' => $item->payment_status,
                'report_id' => $item->report_id,
                'student_id' => $item->student_id,
                'student_name' => $item->student_name,
                'date_issued' => $item->date_issued
            );
            if ($item->payment_status == 'Pending'){
                array_push($data_arr['pendingList'], $arr);
            }
            array_push($data_arr['paymentList'], $arr);
        }
        echo json_encode($data_arr);
    }
    catch(Exception $e){
        echo json_encode($e->getMessage()
            // array('message' => "Fail")
        );
    }
?>
