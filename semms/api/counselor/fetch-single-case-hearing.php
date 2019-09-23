<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/BeanConfig.php';

    $data = json_decode(file_get_contents("php://input"));

    $stage_id = $data->stage_id;
    $data_arr = array();
    $data_arr['stageDetails'] = array();
    $data_arr['message'] = "Success"; 

    try{
        $result = R::getAll("
        SELECT 
        cases.id AS case_id, 
        hearing.id AS stage_id, 
        hearing.notes_remarks, 
        hearing.result,
        hearing.hearing_session_date,
        hearing.hearing_session_start,
        hearing.hearing_session_end,  
        stagehistory.id AS history_id,
        stagehistory.status AS stage_status,
        stagehistory.type,
        stagehistory.created_date AS stage_created_date,
        stagehistory.last_updated AS stage_last_updated
        FROM stagehistory
        INNER JOIN cases
        ON stagehistory.case_id = cases.id
        INNER JOIN hearing
        ON stagehistory.stage_id = hearing.id
        WHERE hearing.id = ? && stagehistory.type = 'Hearing'
        LIMIT 1
        ", [$stage_id] );

        $data_arr['stageDetails'] = $result;

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
