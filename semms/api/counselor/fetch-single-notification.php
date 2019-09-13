<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../model/Notification.php';

    $database = new Database();
    $db = $database->connect();
    $notification = new Notification($db);

    $data = json_decode(file_get_contents("php://input"));

    $notification->notification_id = $data->notification_id;

    if ($notification->changeToRead()){
        $data_arr = array();
        $data_arr['notification'] = array();
        $data_arr['message'] = '';
        $result = $notification->readbyId();
        $num = $result->rowCount();
        if ($num > 0){
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $arr = array(
                    'notification_id' => $notification_id,
                    'subject' => $subject,
                    'description' => $description,
                    'related_id' => $related_id,
                    'tag' => $tag,
                    'date_triggered' => $date_triggered,
                    'is_read' => $is_read
                );

                array_push($data_arr['notification'], $arr);
            }
            $data_arr['message'] = 'Success';
            echo json_encode($data_arr);
        }
        else{
            echo json_encode(
                array('message' => 'Failed')
            );
        }
    }
    else{
        echo json_encode(
            array('message' => 'Failed')
        );
    }
    
?>