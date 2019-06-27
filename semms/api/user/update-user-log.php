<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/User.php';

    $database = new Database();
    $db = $database->connect();

    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    $user->user_id = $data->user_id;

    if($user->updateUserLog()) {
        echo json_encode(
            array('message' => 'User Log Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'User Log Not Updated')
        );
    }
?>
