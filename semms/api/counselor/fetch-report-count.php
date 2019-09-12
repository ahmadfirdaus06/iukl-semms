<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../model/Report.php';

    $database = new Database();
    $db = $database->connect();
    $report = new Report($db);

    $data_arr = array();
    $data_arr['reportCount'] = '';
    $data_arr['message'] = '';
    $result = $report->readAll();
    if ($result){
        $num = $result->rowCount();
        $data_arr['reportCount'] = $num;
        $data_arr['message'] = 'Success';
        echo json_encode($data_arr);
    }
    else{
        echo json_encode(
            array('message' => 'Failed')
        );
    }
?>