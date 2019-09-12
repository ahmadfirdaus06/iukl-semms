<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../model/Notification.php';

    $database = new Database();
    $db = $database->connect();
    $notification = new Notification($db);

    $data_arr = array();
    $data_arr['notificationList'] = array();
    $data_arr['message'] = '';
    $data_arr['unreadCount'] = "";
    $count = 0;
    $result = $notification->readAll();
    $num = $result->rowCount();
    if ($num > 0){
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            if ($is_read == 'No'){
                $count += 1;
            }
            $arr = array(
                'notification_id' => $notification_id,
                'subject' => $subject,
                'description' => $description,
                'related_id' => $related_id,
                'tag' => $tag,
                'date_triggered' => $date_triggered,
                'is_read' => $is_read
            );

            array_push($data_arr['notificationList'], $arr);
        }
        $data_arr['message'] = 'Success';
        $data_arr['unreadCount'] = $count;
        echo json_encode($data_arr);
    }
    else{
        echo json_encode(
            array('message' => 'Failed')
        );
    }

    

?>