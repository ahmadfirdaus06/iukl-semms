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

        public function readById(){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE user_id = ? LIMIT 0,1';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->user_id);

            $stmt->execute();

            return $stmt;
        }

        public function insert(){

        }

        public function update(){

        }

        public function delete(){

        }
    
    }
?>