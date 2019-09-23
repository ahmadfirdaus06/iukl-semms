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
    
    $status = 'Done';

    $final_result = htmlspecialchars(strip_tags($data->result));

    $case_id = htmlspecialchars(strip_tags($data->case_id));

    try{
        switch($type){
            case 'Primary Investigation':
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
                break;
            
            case 'Hearing':
                $session_date = htmlspecialchars(strip_tags($data->hearing_session_date));
                $session_start = htmlspecialchars(strip_tags($data->hearing_session_start));
                $session_end = htmlspecialchars(strip_tags($data->hearing_session_end));
                //update and finish case hearing
                R::exec("
                UPDATE stagehistory, hearing
                SET
                stagehistory.last_updated = ?,
                stagehistory.status = ?,
                hearing.notes_remarks = ?,
                hearing.result = ?,
                hearing.hearing_session_date = ?,
                hearing.hearing_session_start = ?,
                hearing.hearing_session_end = ?
                WHERE stagehistory.stage_id = hearing.id AND stagehistory.stage_id = ? && stagehistory.type = ?
                ", [$last_updated, $status, $notes_remarks, $final_result, $session_date, $session_start, $session_end, $stage_id, $type]);
                break;
        }
        
        //create new hearing record
        $appeal = R::dispense('appeal');
        $appeal->case_id = $case_id;
        $appeal->result = '';
        $appeal->student_appeal_request_details = '';
        $appeal->appeal_submitted_date = null;
        $appeal->request_status = '';
        $appeal->notes_remarks = '';
        $stage_id = R::store($appeal);

        //create new case history record
        $history =  R::dispense('stagehistory');
        $history->case_id = $case_id;
        $history->stage_id = $stage_id;
        $history->created_date = $last_updated;
        $history->last_updated = $last_updated;
        $history->type = 'Appeal';
        $history->status = 'Ongoing';
        R::store($history);

        echo json_encode(
            array(
                'message' => 'Success'
            )
        );

    }
    catch(Exception $e){
        echo json_encode(
            array(
                'message' => 'Fail'
            )
        );
    }
?>