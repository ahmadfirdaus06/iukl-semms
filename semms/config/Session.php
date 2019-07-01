<?php
   include_once '../../config/Database.php';
   session_start();
   
   
   $user_check = $_SESSION['login_user'];
   
   $sql = "SELECT * FROM user WHERE matric_id = '$user_check'";
   $result = mysqli_query($conn, $sql);
   
   $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
   
   if(!isset($_SESSION['login_user'])){
      header("location:http://localhost/semms/login.php");
      die();
   }
?>