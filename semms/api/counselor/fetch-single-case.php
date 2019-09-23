<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/BeanConfig.php';

    $data = json_decode(file_get_contents("php://input"));

    $report_id = $data->report_id;
    $data_arr = array();
    $data_arr['caseDetails'] = array();
    $data_arr['stageList'] = array();
    $data_arr['paymentDetails'] = array();
    $data_arr['message'] = "Success"; 

    try{
        $result = R::getAll('
        SELECT 
        cases.id AS case_id, 
        cases.report_id, 
        cases.status AS case_status, 
        cases.created_date AS date_started, 
        stagehistory.type, 
        stagehistory.status AS stage_status, 
        stagehistory.created_date AS date_history_created, 
        stagehistory.stage_id, 
        stagehistory.last_updated,
        payment.id AS payment_id,
        payment.outstanding,
        payment.payment_status
        FROM stagehistory
        INNER JOIN cases
        ON stagehistory.case_id = cases.id
        INNER JOIN payment
        ON cases.id = payment.case_id
        WHERE cases.report_id = ?
        ORDER BY date_history_created ASC   
        ', [$report_id] );

        //add into stage list
        foreach ($result as $item){
            $obj = json_decode(json_encode($item));
            $arr1 = array(
                'stage_id' => $obj->stage_id,
                'type' => $obj->type,
                'status' => $obj->stage_status,
                'created_date' => $obj->date_history_created,
                'last_updated' => $obj->last_updated
            );

            $arr2 = array(
                'case_id' => $obj->case_id,
                'report_id' => $obj->report_id,
                'status' => $obj->case_status,
                'created_date' => $obj->date_started
            );

            $arr3 = array(
                'payment_id' => $obj->payment_id,
                'payment_outstanding' => $obj->outstanding,
                'payment_status' => $obj->payment_status

            );

            array_push($data_arr['stageList'], $arr1);
            
        }
        
        array_push($data_arr['caseDetails'], $arr2);

        array_push($data_arr['paymentDetails'], $arr3);

        echo json_encode($data_arr);
    }
    catch(Exception $e){
        echo json_encode(
            array(
                'message' => 'Fail'
            )
        );
    }
?>
