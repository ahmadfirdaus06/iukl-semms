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
    
    $status = 'Awaiting Payment';

    $final_result = htmlspecialchars(strip_tags($data->result));

    $case_id = htmlspecialchars(strip_tags($data->case_id));

    $fine_amount = htmlspecialchars(strip_tags($data->fine_amount));

    $email->issued_amount = $fine_amount;

    $payment_status = 'Pending';

    try{
        //update fine settlement
        R::exec("
        UPDATE stagehistory, finesettlement
        SET
        stagehistory.last_updated = ?,
        stagehistory.status = ?,
        finesettlement.notes_remarks = ?,
        finesettlement.result = ?,
        finesettlement.fine_amount = ?
        WHERE stagehistory.stage_id = finesettlement.id AND stagehistory.stage_id = ? && stagehistory.type = ?
        ", [$last_updated, $status, $notes_remarks, $final_result, $fine_amount, $stage_id, $type]);

        //create new payment record
        $payment = R::dispense('payment');
        $payment->case_id = $case_id;
        $payment->outstanding = $fine_amount;
        $payment->payment_status = $payment_status;
        $payment->last_paid = null;
        R::store($payment);

        if ($email->paymentSet()){
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
                'message' => $e->getMessage()
            )
        );
    }
?>