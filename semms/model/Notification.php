<?php
    class Notification{
        //db 
        private $conn;
        private $table = 'notification';

        //properties
        public $notification_id;
        public $subject;
        public $description;
        public $related_id;
        public $tag;
        public $date_triggered;
        public $is_read;

        public function __construct($db){
            $this->conn = $db;
        }

        public function readAll(){

            $query = 'SELECT * FROM ' . $this->table . ' ORDER BY date_triggered DESC';
            
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function readById(){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE notification_id = ? LIMIT 1';
            
            $stmt = $this->conn->prepare($query);

            // $this->notification_id = htmlspecialchars(strip_tags($this->notification_id));

            $stmt->bindParam(1, $this->notification_id);

            $stmt->execute();

            return $stmt;
        }

        public function changeToRead(){
            $query = 'UPDATE ' . $this->table . '
            SET  
            is_read = :is_read
            WHERE notification_id = :notification_id';

            $stmt = $this->conn->prepare($query);

            $this->is_read = 'Yes';

            if (!is_null($this->notification_id)){
                $this->notification_id = htmlspecialchars(strip_tags($this->notification_id));
            }

            $stmt->bindParam(':is_read', $this->is_read);
            $stmt->bindParam(':notification_id', $this->notification_id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function insertReportType(){
            
            $query = 'INSERT INTO ' . $this->table . ' SET 
            subject = :subject,
            description = :description,
            related_id = :related_id,
            tag = :tag';
            
            $stmt = $this->conn->prepare($query);

            $reporter_details = $this->getReporterId();
            
            if(count($reporter_details) != 0){
                extract($reporter_details);
                $text_description = $name . '(' . $id .') has submitted a report on ' . $submitted_date . ".";
            }
            else{
                $text_description = 'An invigilator has submitted a report.';
            }
            
            $text_subject = 'Report #' . $this->related_id . ' submitted.';
            
            $text_tag = 'report';

            $this->subject = htmlspecialchars(strip_tags($text_subject));
            $this->description = htmlspecialchars(strip_tags($text_description));
            $this->related_id = htmlspecialchars(strip_tags($this->related_id));
            $this->tag = htmlspecialchars(strip_tags($text_tag));

            $stmt->bindParam(':subject', $this->subject);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':related_id', $this->related_id);
            $stmt->bindParam(':tag', $this->tag);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function getReporterId(){

            $query = 'SELECT User.name, User.staff_id, Report.uploaded_by FROM Report INNER JOIN User ON Report.reporter_id = User.user_id WHERE report_id = ? && is_valid = "Yes" LIMIT 1';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->related_id);

            $stmt->execute();

            $reporter_arr = array();

            $num = $stmt->rowCount();

            if ($num > 0){
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $reporter_arr['name'] = $row['name'];
                    $reporter_arr['id'] = $row['staff_id'];
                    $reporter_arr['submitted_date'] = $row['uploaded_by'];
                }
            }
            return $reporter_arr;
        }



    }
?>