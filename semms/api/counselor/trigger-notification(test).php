<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/Notification.php';

    $database = new Database();
    $db = $database->connect();

    $notification = new Notification($db);

    $data = json_decode(file_get_contents("php://input"));

    $notification->tag = $data->tag;

    if ($notification->tag == 'report'){
        $notification->related_id = $data->report_id;
        if($notification->insertReportType()) {
            echo json_encode(
                array('message' => 'Success')
            );
        } 
        else {
            echo json_encode(
                array('message' => 'Failed')
            );
        }
    }
    else if ($notification->tag == 'payment'){
            $notification->related_id = $data->payment_id;
            if($notification->insertPaymentType()) {
                echo json_encode(
                    array('message' => 'Success')
                );
            } 
            else {
                echo json_encode(
                    array('message' => 'Failed')
                );
            }
    }
?>
