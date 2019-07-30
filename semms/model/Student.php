<?php
    class Student{
        //db 
        private $conn;
        private $table = 'student';

        //properties
        public $student_id;
        public $matric_id;
        public $ic_or_passport;
        public $name;
        public $programme;
        public $contact_no;
        public $email;

        public function __construct($db){
            $this->conn = $db;
        }

        public function readAll(){

            $query = 'SELECT * FROM ' . $this->table;
            
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function readByMatricId(){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE matric_id = ? LIMIT 0,1';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->matric_id);

            $stmt->execute();

            return $stmt;
        }

        
    }
?>