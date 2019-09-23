<?php
    class Cases{
        //db 
        private $cases;
        private $table = 'cases';

        //properties
        public $id;
        public $report_id;
        public $status;
        public $created_date;
        public $last_updated;

        public function __construct(){
            
        }

        public function create(){
            $case_obj = R::dispense($this->table);
            $case_obj->report_id = $this->report_id;
            try{
                $this->id = R::store($case_obj);
                return true;
            }
            catch(Exception $e) {
                echo json_encode(e);
                return false;
            }
        }

        public function readAll(){
            try{
                return R::find($this->table, ' ORDER BY created_date DESC');
            }
            catch(Exception $e) {
                return null;
            }
        }
    }
    
?>