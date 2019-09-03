<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/Attachment.php';

    $database = new Database();
    $db = $database->connect();

    $attachment = new Attachment($db);

    $data = json_decode(file_get_contents("php://input"));
    
    $img_paths = $data->paths;
    $attachment->report_id = $data->report_id;
    $count = 0;
    $total = count($img_paths);

    foreach($img_paths as $path){
        // $path = str_replace('\/','/',$path);
        // $attachment->path = str_replace('../../../../semms-uploads/','',$path);
        $attachment->path = str_replace('\/','/',$path);
        if ($attachment->create()){
            $count++;
        }
    }
    if ($count == $total){
        $conn = $db;
        $report_id = $attachment->report_id;
        $table = 'report';
        $query = 'UPDATE ' . $table . '
            SET 
            is_valid = IFNULL(:is_valid, is_valid)
            WHERE report_id = :report_id';
            
            $stmt = $conn->prepare($query);

            $is_valid = htmlspecialchars(strip_tags('Yes')); 

            $stmt->bindParam(':is_valid', $is_valid);
            $stmt->bindParam(':report_id', $report_id);

            if($stmt->execute()) {
                echo json_encode(
                    array(
                        'message' => 'Success',
                        'report_id' => $report_id)
                );
            }
            else{
                echo json_encode(
                    array('message' => 'Failed')
                );
            }
    }
    else {
        echo json_encode(
            array('message' => 'Failed')
        );
    }
?>
