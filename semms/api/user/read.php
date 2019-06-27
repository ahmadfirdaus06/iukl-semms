<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../model/User.php';

    $database = new Database();
    $db = $database->connect();
    $user = new User($db);
    if (isset($_GET['user_id'])){
        $user->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();
        $result = $user->readById();
    }
    else{
        $result = $user->readAll();
    }

    $num = $result->rowCount();

    if ($num > 0){
        $user_arr = array();
        $user_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $user_attr = array(
                'user_id' => $user_id,
                'staff_id' => $staff_id,
                'password' => $password,
                'name' => $name,
                'email' => $email,
                'contact_no' => $contact_no,
                'user_type' => $user_type,
                'created_date' => $created_date,
                'modified_date' => $modified_date,
                'last_login' => $last_login
            );

            array_push($user_arr['data'], $user_attr);
        }

        echo json_encode($user_arr);
    }
    else{
        echo json_encode(
            array('message' => 'No User Found')
        );
    }
?>