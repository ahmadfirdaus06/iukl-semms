<?php
    class User{
        //db 
        private $conn;
        private $table = 'user';

        //properties
        public $user_id;
        public $staff_id;
        public $password;
        public $name;
        public $email;
        public $contact_no;
        public $user_type;
        public $created_date;
        public $modified_date;
        public $last_login;

        public function __construct($db){
            $this->conn = $db;
        }

        public function readAll(){
            $query = 'SELECT * FROM ' . $this->table;
            
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }
    
    }
?>