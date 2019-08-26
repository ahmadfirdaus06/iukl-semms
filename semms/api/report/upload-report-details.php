<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/Report.php';

    $database = new Database();
    $db = $database->connect();

    $report = new Report($db);

    $data = json_decode(file_get_contents("php://input"));

    echo json_encode(
        array('message' => $data)
    )
    // $report->staff_id = $data->staff_id;
    // $report->name = $data->name;
    // $report->contact_no = $data->contact_no;
    // $report->user_type = $data->user_type;
    // $report->email = $data->email;

    // if($user->create()) {
    //     echo json_encode(
    //         array('message' => 'User Created')
    //     );
    // } 
    // else {
    //     echo json_encode(
    //         array('message' => 'User Not Created')
    //     );
    // }
?>
