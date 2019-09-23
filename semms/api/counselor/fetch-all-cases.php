<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/BeanConfig.php';
    include_once '../../model/Cases.php';

    $cases = new Cases();

    $data_arr = array();
    $data_arr['caseList'] = array();
    $data_arr['ongoingList'] = array();
    $data_arr['message'] = "Success"; 

    $result = $cases->readAll();
    if ($result != null){
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
    else{
        echo json_encode(
            array('message' => "Fail")
        );
    }
?>
