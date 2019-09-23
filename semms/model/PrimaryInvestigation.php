<?php
    
    class PrimaryInvestigation{
        //db 
        private $primary_inv;
        public $table = 'primaryinvestigation';

        //properties
        public $id;
        public $case_id;
        public $status;
        public $notes;
        public $final_result;


        public function __construct(){
            
        }

        public function create(){
            date_default_timezone_set("Asia/Kuala_Lumpur");

            $primary_inv_obj = R::dispense($this->table);
            $primary_inv_obj->case_id = $this->case_id;

            try{
                $this->id = R::store($primary_inv_obj);
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function readAll(){
            return R::findAll($this->table);
        }
    }
    
?>