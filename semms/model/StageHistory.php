<?php
    
    class StageHistory{
        //db 
        private $history;
        private $table = 'stagehistory';
        public $result;

        //properties
        public $id;
        public $case_id;
        public $stage_id;
        public $type;
        public $status;
        public $created_date;
        public $last_updated;


        public function __construct(){
            
        }

        public function create(){
            date_default_timezone_set("Asia/Kuala_Lumpur");

            switch($this->type){
                case 'primaryinvestigation':
                    $this->type = 'Primary Investigation';
                    break;
                case 'hearing':
                    $this->type = "Hearing";
                    break;
                case 'appeal':
                    $this->type = "Appeal";
                    break;
                case 'finesettlement':
                    $this->type = "Fine Settlement";
                    break;
            }

            $history_obj = R::dispense($this->table);
            $history_obj->case_id = $this->case_id;
            $history_obj->stage_id = $this->stage_id;
            $history_obj->type = $this->type;
            $history_obj->status = 'Ongoing';
            $history_obj->created_date = date("Y-m-d H:i:s");
            $history_obj->last_updated = date("Y-m-d H:i:s");

            try{
                $this->id = R::store($history_obj);
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function readById(){
            try{
                $this->result = R::findOne($this->table, ' id = ? ', [$this->id]);
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }
    }
    
?>