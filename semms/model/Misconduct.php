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

    }
?>