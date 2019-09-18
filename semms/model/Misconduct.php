<?php
    class Misconduct{
        //db 
        private $conn;
        private $table = 'misconduct';

        //properties
        public $misconduct_id;
        public $type;
        public $reporter_id;

        public function __construct($db){
            $this->conn = $db;
        }

        public function readAll(){

            $query = 'SELECT * FROM ' . $this->table;
            
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function readByReportId(){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE report_id = ?';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->report_id);

            $stmt->execute();

            return $stmt;
        }


    }
?>