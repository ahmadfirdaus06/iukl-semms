<?php
    session_start();
    if (isset($_SESSION['user'])){
        if ($_SESSION['user_type'] == "Admin"){
            header("location:admin/admin-page.php");
        }
        else if ($_SESSION['user_type'] == "Bursary Admin"){
            header("location:bursary_admin/fine-settlement-info.php");
        }
        else if ($_SESSION['user_type'] == "Counselor"){
            header("location:counselor/dashboard.php");
        }	
    }
?>