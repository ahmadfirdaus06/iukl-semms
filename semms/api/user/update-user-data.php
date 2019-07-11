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

    if (array_key_exists("user_id", $data)){
        $user->user_id = $data->user_id;
    }
    else{
        $user->user_id = NULL;
    }
    if (array_key_exists("staff_id", $data)){
        $user->staff_id = $data->staff_id;
    }
    else{
        $user->staff_id = NULL;
    }
    if (array_key_exists("password", $data)){
        $user->password = $data->password;
    }
    else{
        $user->password = NULL;
    }
    if (array_key_exists("name", $data)){
        $user->name = $data->name;
    }
    else{
        $user->name = NULL;
    }
    if (array_key_exists("contact_no", $data)){
        $user->contact_no = $data->contact_no;
    }
    else{
        $user->contact_no = NULL;
    }
    if (array_key_exists("user_type", $data)){
        $user->user_type = $data->user_type;
    }
    else{
        $user->user_type = NULL;
    }
    if (array_key_exists("email", $data)){
        $user->email = $data->email;
    }
    else{
        $user->email = NULL;
    }
    
    // $user->user_id = $data->user_id;
    // $user->staff_id = $data->staff_id;
    // $user->password = $data->password;
    // $user->name = $data->name;
    // $user->contact_no = $data->contact_no;
    // $user->user_type = $data->user_type;
    // $user->email = $data->email;

    if($user->updateUserData()) {
        echo json_encode(
            array('message' => 'User Data Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'User Data Not Updated')
        );
    }
?>
