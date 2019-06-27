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

    $user->staff_id = $data->staff_id;
    $user->password = $data->password;
    $user->name = $data->name;
    $user->contact_no = $data->contact_no;
    $user->user_type = $data->user_type;
    $user->email = $data->email;

    if($user->create()) {
        echo json_encode(
            array('message' => 'User Created')
        );
    } 
    else {
        echo json_encode(
            array('message' => 'User Not Created')
        );
    }
?>
