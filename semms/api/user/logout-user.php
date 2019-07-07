<?php
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: application/json');
   header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
   
   include_once '../../config/Database.php';
   include_once '../../model/User.php';

   session_start();

   $database = new Database();
   $db = $database->connect();

   $user = new User($db);
   $arr = array();

   if (isset($_SESSION['user'])){
      extract($_SESSION['user']);
      $user->user_id = $user_id;

      if($user->updateUserLog()) {
         $arr['message'] = 'User Log Updated';
         
      } 
      else {
         $arr['message'] = 'User Log Not Updated';
      }
  }
   
   

   if(session_destroy()) {
      $arr['message'] = 'Success';
   }
   else{
      $arr['message'] = 'Failed';
   }

   echo json_encode($arr);
?>