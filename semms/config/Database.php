<?php
 class Database{
   //   private $host = '192.168.1.139';
   //   private $host = 'localhost';
      private $host = 'semms.ddns.net';
      private $port = "49152";
      private $db_name = 'iukl_semms';
      private $username = 'root';
      private $password = '';
      private $conn;
     

      public function connect(){
         $this->conn = null;

         try{
            $this->conn = new PDO('mysql:host=' . gethostbyname($this->host) . ';port=' . $this->port . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
         }catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
         }

         return $this->conn;
      }
 }
?>