<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    session_start();
    if (isset($_SESSION['user'])){
        extract($_SESSION['user']);

        if ($user_type == 'Admin'){
            echo json_encode(
                array('url' => 'admin/dashboard')
            );
        }
        else if ($user_type == 'Bursary Admin'){
            echo json_encode(
                array('url' => 'bursary/dashboard')
            );
        }
        else if ($user_type == 'Counselor'){
            echo json_encode(
                array('url' => 'counselor/dashboard')
            );
        }
    }
?>