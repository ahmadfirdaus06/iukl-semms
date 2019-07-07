<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    session_start();
    $arr = array();
    if (isset($_SESSION['user'])){
        $arr['user_session'] = $_SESSION['user'];
        echo json_encode($arr);
    }
?>