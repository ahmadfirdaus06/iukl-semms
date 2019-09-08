<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/User.php';

    $database = new Database();
    $db = $database->connect();

    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    if (array_key_exists("user_id", $data)){
        $user->user_id = $data->user_id;
    }
    else{
        $user->user_id = NULL;
    }
    if (array_key_exists("staff_id", $data)){
        $user->staff_id = $data->staff_id;
    }
    else{
        $user->staff_id = NULL;
    }
    if (array_key_exists("password", $data)){
        $user->password = $data->password;
    }
    else{
        $user->password = NULL;
    }
    if (array_key_exists("name", $data)){
        $user->name = $data->name;
    }
    else{
        $user->name = NULL;
    }
    if (array_key_exists("contact_no", $data)){
        $user->contact_no = $data->contact_no;
    }
    else{
        $user->contact_no = NULL;
    }
    if (array_key_exists("user_type", $data)){
        $user->user_type = $data->user_type;
    }
    else{
        $user->user_type = NULL;
    }
    if (array_key_exists("email", $data)){
        $user->email = $data->email;
    }
    else{
        $user->email = NULL;
    }
    if (array_key_exists("granted_access", $data)){
        $user->granted_access = $data->granted_access;
    }
    else{
        $user->granted_access = NULL;
    }

    if($user->updateUserData()) {
        $result = $user->readByStaffId();
        $num = $result->rowCount();

        if ($num > 0){
            $user_arr = array();
            $user_arr['message'] = 'Success';
            $user_arr['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)){
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
                    'last_login' => $last_login,
                    'granted_access' => $granted_access
                );

                array_push($user_arr['data'], $user_attr);
            }

            echo json_encode($user_arr);
        }
    } else {
        echo json_encode(
            array('message' => 'Failed')
        );
    }
?>
