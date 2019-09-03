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
        public $granted_access;

        public function __construct($db){
            $this->conn = $db;
        }

        public function readAll(){

            session_start();
            
            extract($_SESSION['user']);

            $current_user_id = $user_id;

            $query = 'SELECT * FROM ' . $this->table . ' WHERE user_id != ' .$current_user_id. ' ORDER BY created_date DESC';
            
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

        public function readByStaffId(){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE staff_id = ? LIMIT 0,1';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->staff_id);

            $stmt->execute();

            return $stmt;
        }

        public function readAllAnon(){
            $query = 'SELECT * FROM ' . $this->table;

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function loginWeb(){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE staff_id = ? AND user_type != "Invigilator" AND granted_access = "yes"  LIMIT 0,1';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->staff_id);

            $stmt->execute();

            return $stmt;
        } 

        public function loginMobile(){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE staff_id = ?  AND user_type = "Invigilator" LIMIT 0,1';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->staff_id);

            $stmt->execute();

            return $stmt;
        }

        public function create(){
            
            $query = 'INSERT INTO ' . $this->table . ' SET staff_id = :staff_id, password = :password, name = :name, contact_no = :contact_no, user_type = :user_type, email = :email';
            
            $stmt = $this->conn->prepare($query);

            $this->staff_id = htmlspecialchars(strip_tags($this->staff_id));
            $this->password = password_hash("123", PASSWORD_BCRYPT); //verify using -> password_verify ( string $password , string $hash )
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->contact_no = htmlspecialchars(strip_tags($this->contact_no));
            $this->user_type = htmlspecialchars(strip_tags($this->user_type));
            $this->email = htmlspecialchars(strip_tags($this->email));

            $stmt->bindParam(':staff_id', $this->staff_id);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':contact_no', $this->contact_no);
            $stmt->bindParam(':user_type', $this->user_type);
            $stmt->bindParam(':email', $this->email);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function updateUserData(){
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $query = 'UPDATE ' . $this->table . '
            SET 
            staff_id = IFNULL(:staff_id, staff_id), 
            password = IFNULL(:password, password), 
            name = IFNULL(:name, name), 
            contact_no = IFNULL(:contact_no, contact_no), 
            user_type = IFNULL(:user_type, user_type),
            email = IFNULL(:email, email),
            granted_access = IFNULL(:granted_access, granted_access),
            modified_date = :modified_date
            WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($query);

            if (!is_null($this->staff_id)){
                $this->staff_id = htmlspecialchars(strip_tags($this->staff_id));
            }
            if (!is_null($this->password)){
                $this->password = password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_BCRYPT); //verify using -> password_verify ( string $password , string $hash )
            }
            if (!is_null($this->name)){
                $this->name = htmlspecialchars(strip_tags($this->name));
            }
            if (!is_null($this->contact_no)){
                $this->contact_no = htmlspecialchars(strip_tags($this->contact_no));
            }
            if (!is_null($this->user_type)){
                $this->user_type = htmlspecialchars(strip_tags($this->user_type));
            }
            if (!is_null($this->email)){
                $this->email = htmlspecialchars(strip_tags($this->email));
            }
            if (!is_null($this->user_id)){
                $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            }
            if (!is_null($this->staff_id)){
                $this->staff_id = htmlspecialchars(strip_tags($this->staff_id));
            }
            if (!is_null($this->granted_access)){
                $this->granted_access = htmlspecialchars(strip_tags($this->granted_access));
            }

            $this->modified_date = date("Y-m-d H:i:s"); 

            $stmt->bindParam(':staff_id', $this->staff_id);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':contact_no', $this->contact_no);
            $stmt->bindParam(':user_type', $this->user_type);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':granted_access', $this->granted_access);
            $stmt->bindParam(':modified_date', $this->modified_date);
            $stmt->bindParam(':user_id', $this->user_id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function updateUserLog(){
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $query = 'UPDATE ' . $this->table . '
            SET modified_date = :modified_date, last_login = :last_login
            WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($query);

            $this->modified_date = date("Y-m-d H:i:s"); 
            $this->last_login = date("Y-m-d H:i:s"); 
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));

            $stmt->bindParam(':modified_date', $this->modified_date);
            $stmt->bindParam(':last_login', $this->last_login);
            $stmt->bindParam(':user_id', $this->user_id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function delete(){

            $query = 'DELETE FROM ' . $this->table . ' WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($query);

            $this->user_id = htmlspecialchars(strip_tags($this->user_id));

            $stmt->bindParam(':user_id', $this->user_id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function checkExisting(){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE staff_id = ?';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->staff_id);

            $stmt->execute();

            return $stmt;
        }
    }
?>