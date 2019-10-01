<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/Report.php';
    include_once '../../config/BeanConfig.php';
    include_once '../../model/Cases.php';
    include_once '../../model/PrimaryInvestigation.php';
    include_once '../../model/StageHistory.php';
    include_once '../../config/Email.php';

    $database = new Database();
    $db = $database->connect();
    $report = new Report($db);
    $cases = new Cases();
    $primary_inv = new PrimaryInvestigation();
    $history = new StageHistory();
    $email = new Email();

    $data = json_decode(file_get_contents("php://input"));

    $report->report_id = $data->report_id;
    $report->report_status = $data->report_status;

    $result = $report->approveReport();

    if ($result){

        $cases->report_id = $report->report_id;
        $data_arr = array();
        $data_arr['message'] = "Success"; 
        $data_arr['caseDetails'] = array();

        if ($report->report_status == 'Approved'){
            if ($cases->create() && $email->caseOpened()){
                $primary_inv->case_id = $cases->id;
                if ($primary_inv->create() && $email->primaryInvestigation()){
                    $history->case_id = $cases->id;
                    $history->type = $primary_inv->table;
                    $history->stage_id = $primary_inv->id;
                    if ($history->create()){
                        if ($history->readById()){
                            $data_arr['caseDetails'] = $history->result;
                            echo json_encode($data_arr);
                        }
                    }
                    else{
                        echo json_encode(
                            array('message' => "Fail")
                        );
                    }

                }
                else{
                    echo json_encode(
                        array('message' => "Fail")
                    );
                }
            }   
            else{
                echo json_encode(
                    array('message' => "Fail")
                );
            }
        }

    }
    else{
        echo json_encode(
            array('message' => 'Fail')
        );
    }
?>
