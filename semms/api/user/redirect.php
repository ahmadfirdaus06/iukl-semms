<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    session_start();

    $data = json_decode(file_get_contents("php://input"));

    if (isset($_SESSION['user'])){
        extract($_SESSION['user']);
        if ($user_type == 'Admin'){
            echo json_encode(
                array('url' => 'main.admin-dashboard')
            );
        }
        else if ($user_type == 'Bursary Admin'){
            echo json_encode(
                array('url' => 'main.bursary-dashboard')
            );
        }
        else if ($user_type == 'Counselor'){
            echo json_encode(
                array('url' => 'main.counselor-dashboard')
            );
        }
        else{
            echo json_encode(
                array('url' => 'login')
            );  
        }
        
    }
?>