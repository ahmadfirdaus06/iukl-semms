<?php
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: application/json');
   header('Access-Control-Allow-Methods: POST');
   header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
   
   include_once '../../config/Database.php';
   include_once '../../model/User.php';

   session_start();

   $database = new Database();
   $db = $database->connect();

   $user = new User($db);

   $data = json_decode(file_get_contents("php://input"));

   $arr = array();

   if (isset($_SESSION['user'])){
      extract($_SESSION['user']);
      $user->user_id = $user_id;  
   }
   else{
      $user->user_id = $data->user_id;
   }
   
   if($user->updateUserLog()) {
      
      if(session_destroy()) {
         echo json_encode(
            array('message' => 'Success')
         );
      }
      else{
         echo json_encode(
            array('message' => 'Failed')
         );
      }
   } 
   else {
      echo json_encode(
         array('message' => 'Failed')
      );
   }

?>