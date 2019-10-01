<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/BeanConfig.php';
    include_once '../../config/Email.php';

    $email = new Email();

    $data = json_decode(file_get_contents("php://input"));

    $type = htmlspecialchars(strip_tags($data->type));
    
    $stage_id = htmlspecialchars(strip_tags($data->stage_id));
    
    $notes_remarks = htmlspecialchars(strip_tags($data->notes_remarks));

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $last_updated = date("Y-m-d H:i:s");
    
    $status = 'Done';

    $final_result = htmlspecialchars(strip_tags($data->result));

    $case_id = htmlspecialchars(strip_tags($data->case_id));

    try{
        //update and finish primary investigation
        R::exec("
        UPDATE stagehistory, primaryinvestigation
        SET
        stagehistory.last_updated = ?,
        stagehistory.status = ?,
        primaryinvestigation.notes_remarks = ?,
        primaryinvestigation.result = ?
        WHERE stagehistory.stage_id = primaryinvestigation.id AND stagehistory.stage_id = ? && stagehistory.type = ?
        ", [$last_updated, $status, $notes_remarks, $final_result, $stage_id, $type]);
        
        //create new hearing record
        $hearing = R::dispense('hearing');
        $hearing->case_id = $case_id;
        $hearing->result = '';
        $hearing->hearing_session_date = null;
        $hearing->hearing_session_start = null;
        $hearing->hearing_session_end = null;
        $hearing->notes_remarks = '';
        $stage_id = R::store($hearing);

        //create new case history record
        $history =  R::dispense('stagehistory');
        $history->case_id = $case_id;
        $history->stage_id = $stage_id;
        $history->created_date = $last_updated;
        $history->last_updated = $last_updated;
        $history->type = 'Hearing';
        $history->status = 'Ongoing';
        R::store($history);

        if ($email->hearing()){
            echo json_encode(
                array(
                    'message' => 'Success'
                )
            );
        }
        else{
            echo json_encode(
                array(
                    'message' => 'Fail'
                )
            );
        }
    }
    catch(Exception $e){
        echo json_encode(
            array(
                'message' => 'Fail'
            )
        );
    }
?>