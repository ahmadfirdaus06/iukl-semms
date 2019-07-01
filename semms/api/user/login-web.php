<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    session_start();
    include_once '../../config/Database.php';
    include_once '../../model/User.php';

    $database = new Database();
    $db = $database->connect();

    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    $user->staff_id = $data->staff_id;
    $user->password = $data->password;

    $result =$user->loginWeb();

    $num = $result->rowCount();

    if ($num > 0){
        $user_arr = array();
        $user_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            if (password_verify(htmlspecialchars(strip_tags($user->password)), $row['password'])){
                extract($row);
                $user_attr = array(
                    'user_id' => $user_id,
                    'staff_id' => $staff_id,
                    'password' => $password,
                    'name' => $name,
                    'email' => $email,
                    'contact_no' => $contact_no,
                    'user_type' => $user_type,
                    'created_date' => $created_date,
                    'modified_date' => $modified_date,
                    'last_login' => $last_login
                );
                $_SESSION['user'] = $user_attr;
                $SESSION['user_id'] = $row['user_id'];
                $SESSION['user_type'] = $row['user_type'];
                array_push($user_arr['data'], $user_attr);
                $user_arr['message'] = 'Access Granted!';
                echo json_encode($user_arr);
                // echo json_encode(
                //     array('message' => 'Access Granted!')
                // );
            }
            else{
                echo json_encode(
                    array('message' => 'Access Denied!')
                );
            }
        }
        
    }
    else{
        echo json_encode(
            array('message' => 'Access Denied!')
        );
    }
?>    