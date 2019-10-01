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
                return false;
            }
        }

        public function readAll(){
            
            $data_arr = array();
            $data_arr['caseList'] = array();
            $data_arr['ongoingList'] = array();
            $data_arr['message'] = "Success"; 

            try{
                $result =  R::find($this->table, ' ORDER BY created_date DESC');
                foreach($result as $obj){
                    $arr = array(
                        'id' => $obj->id,
                        'report_id' => $obj->report_id,
                        'status' => $obj->status,
                        'created_date' => $obj->created_date,
                        'last_updated' => $obj->last_updated
                    );
                    if ($obj->status == 'Ongoing'){
                        array_push($data_arr['ongoingList'], $arr);
                    }
                    array_push($data_arr['caseList'], $arr);
                    
                }
                echo json_encode($data_arr);
            }
            catch(Exception $e) {
                echo json_encode(
                    array('message' => "Fail")
                );
            }
        }
    }
    
?>