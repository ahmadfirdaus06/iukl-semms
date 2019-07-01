<?php
    include_once '../../config/Session.php';

    if ($_SESSION['user_type'] != $_GET['access_type']){
        header("location:http://localhost:8080/semms/403.php");
    }
?>