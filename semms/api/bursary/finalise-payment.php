<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/BeanConfig.php';
    include_once '../../config/Email.php';

    $email = new Email();

    $data = json_decode(file_get_contents("php://input"));

    $case_id = htmlspecialchars(strip_tags($data->case_id));
    $outstanding = htmlspecialchars(strip_tags($data->outstanding - $data->paid_amount));
    $payment_id = htmlspecialchars(strip_tags($data->payment_id));
    $type = 'Fine Settlement';
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $last_updated = date("Y-m-d H:i:s");
    $payment_status = 'Paid';
    $stage_status = 'Done';
    $case_status = 'Closed';
    $text_subject = 'Payment #' . $payment_id .' completed.';
    $text_description = $data->student_name . '(' . $data->student_id . ') has completed payment on ' . $last_updated . '.';
    $tag = 'payment';

    try{
        R::exec("
        UPDATE stagehistory, payment
        SET
        payment.outstanding = ?,
        payment.last_paid = ?,
        stagehistory.last_updated = ?
        WHERE stagehistory.case_id = payment.case_id AND payment.id = ? && payment.case_id = ? && stagehistory.type = 'Fine Settlement'
        ", [$outstanding, $last_updated, $last_updated, $payment_id, $case_id]);
        
        $email->paid_amount = $data->paid_amount;
        $email->outstanding = $outstanding;
        $email->paid();
        
        if ($outstanding == 0.00){
            R::exec("
            UPDATE stagehistory, payment, cases
            SET
            stagehistory.status = ?,
            payment.payment_status = ?,
            cases.status = ?
            WHERE cases.id = stagehistory.case_id AND cases.id = payment.case_id AND payment.id = ? && payment.case_id = ? && stagehistory.type = 'Fine Settlement'
            ", [$stage_status, $payment_status, $case_status, $payment_id, $case_id]);

            $notification = R::dispense('notification');
            $notification->subject = $text_subject;
            $notification->description = $text_description;
            $notification->related_id = $payment_id;
            $notification->tag = $tag;
            R::store($notification);
            $email->caseClosed();
        }
        echo json_encode(
            array(
                'message' =>'Success'
            )
        );
        
    }
    catch(Exception $e){
        echo json_encode(
            array(
                'message' =>'Fail'
            )
        );
    }
?>