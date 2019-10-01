<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/BeanConfig.php';

    $data = json_decode(file_get_contents("php://input"));

    $type = htmlspecialchars(strip_tags($data->type));
    
    $stage_id = htmlspecialchars(strip_tags($data->stage_id));
    
    $notes_remarks = htmlspecialchars(strip_tags($data->notes_remarks));

    date_default_timezone_set("Asia/Kuala_Lumpur");

    $last_updated = date("Y-m-d H:i:s");
    
    $stage_status = 'Done';

    $case_status = 'Dropped';

    $final_result = htmlspecialchars(strip_tags($data->result));

    $case_id = htmlspecialchars(strip_tags($data->case_id));

    $session_date = htmlspecialchars(strip_tags($data->hearing_session_date));
    $session_start = htmlspecialchars(strip_tags($data->hearing_session_start));
    $session_end = htmlspecialchars(strip_tags($data->hearing_session_end));

    try{
        
        //update and finish case hearing
        R::exec("
        UPDATE stagehistory, hearing, cases
        SET
        stagehistory.last_updated = ?,
        stagehistory.status = ?,
        cases.status = ?,
        hearing.notes_remarks = ?,
        hearing.result = ?,
        hearing.hearing_session_date = ?,
        hearing.hearing_session_start = ?,
        hearing.hearing_session_end = ?
        WHERE stagehistory.case_id = cases.id AND stagehistory.stage_id = hearing.id AND stagehistory.stage_id = ? && stagehistory.type = ?
        ", [$last_updated, $stage_status, $case_status, $notes_remarks, $final_result, $session_date, $session_start, $session_end, $stage_id, $type]);

        if ($email->caseClosed()){
            echo json_encode(
                array(
                    'message' =>'Success'
                )
            );
        }
        else{
            echo json_encode(
                array(
                    'message' =>'Fail'
                )
            );
        }
    }
    catch(Exception $e){
        echo json_encode(
            array(
                'message' => $e->getMessage()
            )
        );
    }
?>