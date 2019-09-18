<?php
    class Report{
        //db 
        private $conn;
        private $table = 'report';

        //properties
        public $report_id;
        public $student_id;
        public $reporter_id;
        public $superior_id;
        public $course_code;
        public $course_name;
        public $exam_venue;
        public $exam_date;
        public $exam_time;
        public $misconduct_time;
        public $misconduct_description;
        public $action_taken;
        public $witness1_name;
        public $witness1_contact_no;
        public $witness1_email;
        public $witness2_name;
        public $witness2_contact_no;
        public $witness2_email;
        public $uploaded_by;
        public $last_approval_date;
        public $is_valid;
        public $case_status;
        public $report_status;

        public function __construct($db){
            $this->conn = $db;
        }

        public function readAll(){

            $query = 'SELECT * FROM ' . $this->table . ' WHERE is_valid = "Yes" ORDER BY uploaded_by DESC';
            
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function readByReporterId(){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE reporter_id = ? && is_valid = "Yes"';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->reporter_id);

            $stmt->execute();

            return $stmt;
        }

        public function readbyReportId(){
            $query = 'SELECT 
            report.report_id,
            report.course_code,
            report.course_name,
            report.exam_venue,
            report.exam_date,
            report.exam_time,
            report.misconduct_time,
            report.misconduct_description,
            report.action_taken,
            report.witness1_name,
            report.witness1_contact_no,
            report.witness1_email,
            report.witness2_name,
            report.witness2_contact_no,
            report.witness2_email,
            report.uploaded_by,
            report.last_approval_date,
            report.is_valid,
            report.case_status,
            report.report_status,
            student.matric_id,
            student.ic_or_passport,
            student.name AS student_name,
            student.programme,
            student.contact_no AS student_contact_no,
            student.email AS student_email,
            user.staff_id,
            user.name AS reporter_name,
            user.email AS reporter_email,
            user.contact_no AS reporter_contact_no
            FROM ' . $this->table . ' 
            INNER JOIN student ON report.student_id = student.student_id
            INNER JOIN user ON report.reporter_id = user.user_id
            WHERE report_id = ? && is_valid = "Yes"';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->report_id);

            $stmt->execute();

            return $stmt;
        }

        public function create(){
            
            $query = 'INSERT INTO ' . $this->table . ' SET 
            student_id = :student_id,
            reporter_id = :reporter_id,
            superior_id = :superior_id,
            course_code = :course_code,
            course_name = :course_name,
            exam_venue = :exam_venue,
            exam_date = :exam_date,
            exam_time = :exam_time,
            misconduct_time = :misconduct_time,
            misconduct_description = :misconduct_description,
            action_taken = :action_taken,
            witness1_name = :witness1_name,
            witness1_contact_no = :witness1_contact_no,
            witness1_email = :witness1_email,
            witness2_name = :witness2_name,
            witness2_contact_no = :witness2_contact_no,
            witness2_email = :witness2_email';
            
            $stmt = $this->conn->prepare($query);

            $this->student_id = htmlspecialchars(strip_tags($this->student_id));
            $this->reporter_id = htmlspecialchars(strip_tags($this->reporter_id));
            $this->superior_id = htmlspecialchars(strip_tags($this->superior_id));
            $this->course_code = htmlspecialchars(strip_tags($this->course_code));
            $this->course_name = htmlspecialchars(strip_tags($this->course_name));
            $this->exam_venue = htmlspecialchars(strip_tags($this->exam_venue));
            $this->exam_date = htmlspecialchars(strip_tags($this->exam_date));
            $this->exam_time = htmlspecialchars(strip_tags($this->exam_time));
            $this->misconduct_time = htmlspecialchars(strip_tags($this->misconduct_time));
            $this->misconduct_description = htmlspecialchars(strip_tags($this->misconduct_description));
            $this->action_taken = htmlspecialchars(strip_tags($this->action_taken));
            $this->witness1_name = htmlspecialchars(strip_tags($this->witness1_name));
            $this->witness1_contact_no = htmlspecialchars(strip_tags($this->witness1_contact_no));
            $this->witness1_email = htmlspecialchars(strip_tags($this->witness1_email));
            $this->witness2_name = htmlspecialchars(strip_tags($this->witness2_name));
            $this->witness2_contact_no = htmlspecialchars(strip_tags($this->witness2_contact_no));
            $this->witness2_email = htmlspecialchars(strip_tags($this->witness2_email));

            $stmt->bindParam(':student_id', $this->student_id);
            $stmt->bindParam(':reporter_id', $this->reporter_id);
            $stmt->bindParam(':superior_id', $this->superior_id);
            $stmt->bindParam(':course_code', $this->course_code);
            $stmt->bindParam(':course_name', $this->course_name);
            $stmt->bindParam(':exam_venue', $this->exam_venue);
            $stmt->bindParam(':exam_date', $this->exam_date);
            $stmt->bindParam(':exam_time', $this->exam_time);
            $stmt->bindParam(':misconduct_time', $this->misconduct_time);
            $stmt->bindParam(':misconduct_description', $this->misconduct_description);
            $stmt->bindParam(':action_taken', $this->action_taken);
            $stmt->bindParam(':witness1_name', $this->witness1_name);
            $stmt->bindParam(':witness1_contact_no', $this->witness1_contact_no);
            $stmt->bindParam(':witness1_email', $this->witness1_email);
            $stmt->bindParam(':witness2_name', $this->witness2_name);
            $stmt->bindParam(':witness2_contact_no', $this->witness2_contact_no);
            $stmt->bindParam(':witness2_email', $this->witness2_email);

            if($stmt->execute()) {
                return $this->conn->lastInsertId();
            }

            printf("Error: %s.\n", $stmt->error);

            return '';
        }

        public function approveReport(){
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $query = 'UPDATE ' . $this->table . '
            SET 
            report_status = IFNULL(:report_status, report_status), 
            last_approval_date = :last_approval_date
            WHERE report_id = :report_id';

            $stmt = $this->conn->prepare($query);

            if (!is_null($this->report_status)){
                $this->report_status = htmlspecialchars(strip_tags($this->report_status));
            }
            if (!is_null($this->report_id)){
                $this->report_id = htmlspecialchars(strip_tags($this->report_id));
            }
            
            $this->last_approval_date = date("Y-m-d H:i:s"); 

            $stmt->bindParam(':report_status', $this->report_status);
            $stmt->bindParam(':last_approval_date', $this->last_approval_date);
            $stmt->bindParam(':report_id', $this->report_id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function updateReportCase(){
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $query = 'UPDATE ' . $this->table . '
            SET 
            case_status = IFNULL(:case_status, case_status)
            WHERE report_id = :report_id';

            $stmt = $this->conn->prepare($query);

            if (!is_null($this->case_status)){
                $this->case_status = htmlspecialchars(strip_tags($this->case_status));
            }

            $stmt->bindParam(':case_status', $this->case_status);
            $stmt->bindParam(':report_id', $this->report_id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }
?>