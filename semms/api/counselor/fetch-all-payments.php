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
        $result = R::find('payment', ' ORDER BY id DESC');
        foreach($result as $obj){
            $arr = array(
                'id' => $obj->id,
                'case_id' => $obj->case_id,
                'outstanding' => $obj->outstanding,
                'amount_paid' => $obj->amount_paid,
                'payment_status' => $obj->payment_status,
                'last_paid' => $obj->last_paid
            );
            if ($obj->payment_status == 'Pending'){
                array_push($data_arr['pendingList'], $arr);
            }
            array_push($data_arr['paymentList'], $arr);
            
        }
        echo json_encode($data_arr);
    }
    catch(Exception $e){
        echo json_encode(
            array('message' => "Fail")
        );
    }
?>
