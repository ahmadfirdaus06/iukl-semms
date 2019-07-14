<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/User.php';

    $database = new Database();
    $db = $database->connect();

    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    if (array_key_exists("staff_id", $data)){
        $user->staff_id = $data->staff_id;
    }
    $result =$user->checkExisting();

    $num = $result->rowCount();

    if ($num > 0){
        echo json_encode(
            array('message' => 'User Existed')
        );
    }
    else if ($num == 0){
        echo json_encode(
            array('message' => 'User Not Existed')
        );
    }
?>    