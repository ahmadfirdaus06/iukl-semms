<?php
    class Attachment{
        //db 
        private $conn;
        private $table = 'attachment';

        //properties
        public $report_id;
        public $path;
        public $attachment_id;

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