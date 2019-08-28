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

        public function readByReportId(){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE report_id = ? LIMIT 0,1';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->report_id);

            $stmt->execute();

            return $stmt;
        }

        public function create(){
            
            $query = 'INSERT INTO ' . $this->table . ' SET 
            path = :path,
            report_id = :report_id';
            
            $stmt = $this->conn->prepare($query);

            $this->path = htmlspecialchars(strip_tags($this->path));
            $this->report_id = htmlspecialchars(strip_tags($this->report_id));

            $stmt->bindParam(':path', $this->path);
            $stmt->bindParam(':report_id', $this->report_id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }
?>