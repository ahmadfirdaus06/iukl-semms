<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/Report.php';

    $database = new Database();
    $db = $database->connect();

    $report = new Report($db);

    $data = json_decode(file_get_contents("php://input"));

    $report->report_id = $data->report_id;
    $report->report_status = $data->report_status;

    $result = $report->approveReport();

    if ($result){
        echo json_encode(
            array('message' => 'Success')
        );

    }
    else{
        echo json_encode(
            array('message' => 'Failed')
        );
    }
?>
