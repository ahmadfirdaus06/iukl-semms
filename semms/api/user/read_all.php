<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../model/User.php';

    $database = new Database();
    echo print_r($database->connect());
    $db = $database->connect();
    echo print_r($db);
    $user = new User($db);
    echo print_r($user);
    $result = $user->readAll();

    $num = $result->rowCount();

    if (num > 0){
        $user_arr = array();
        $user_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $user_attr = array(
                'user_id' => user_id,
                'staff_id' => staff_id,
                'password' => password,
                'name' => name,
                'email' => email,
                'contact_no' => contact_no,
                'user_type' => user_type,
                'created_date' => created_date,
                'modified_date' => modified_date,
                'last_login' => last_login
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