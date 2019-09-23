<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/BeanConfig.php';

    $data = json_decode(file_get_contents("php://input"));

    $payment_id = $data->payment_id; 

    $type = 'Fine Settlement';

    $data_arr['message'] = 'Success';
    $data_arr['paymentDetails'] = array();

    try{
        $result = R::getAll("
        SELECT 
        payment.id AS payment_id,
        payment.case_id,
        payment.outstanding,
        payment.last_paid,
        payment.payment_status,
        cases.report_id,
        student.matric_id AS student_id,
        student.name AS student_name,
        stagehistory.last_updated AS date_issued,
        finesettlement.fine_amount AS issued_amount
        FROM payment
        INNER JOIN cases
        ON payment.case_id = cases.id
        INNER JOIN report 
        ON cases.report_id = report.report_id
        INNER JOIN student
        ON report.student_id = student.student_id
        INNER JOIN stagehistory
        ON cases.id = stagehistory.case_id
        INNER JOIN finesettlement
        ON cases.id = finesettlement.case_id
        WHERE stagehistory.type = ? && payment.id = ?
        ", [$type, $payment_id] );

        $data_arr['paymentDetails'] = $result;

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
