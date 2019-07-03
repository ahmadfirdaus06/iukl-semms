<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    session_start();
    if (isset($_SESSION['user'])){
        if (isset($_GET['page_access'])){
            $page_access = isset($_GET['page_access']) ? $_GET['page_access'] : die();
            echo json_encode($page_access);
        }
    }
?>