<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/BeanConfig.php';

    $data = json_decode(file_get_contents("php://input"));

    $payment_id = $data->payment_id;

    $data_arr['paymentDetails'] = array();
    $data_arr['message'] = "Success"; 

    try{
        $result = R::findOne('payment', 'id = ?', array($payment_id));   

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
