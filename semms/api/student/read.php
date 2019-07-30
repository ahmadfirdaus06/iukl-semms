<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../model/Student.php';

    $database = new Database();
    $db = $database->connect();
    $student = new Student($db);

    $data = json_decode(file_get_contents("php://input"));

    if (!is_null($data)){
        $student->matric_id = $data->matric_id;
        $result = $student->readByMatricId();
    }
    else{
        $result = $student->readAll();
    }

    $num = $result->rowCount();
    if ($num > 0){
        $student_arr = array();
        $student_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $arr = array(
                'student_id' => $student_id,
                'matric_id' => $matric_id,
                'ic_or_passport' => $ic_or_passport,
                'name' => $name,
                'programme' => $programme,
                'contact_no' => $contact_no,
                'email' => $email
            );

            array_push($student_arr['data'], $arr);
        }

        echo json_encode($student_arr);
    }
    else{
        echo json_encode(
            array('message' => 'Not Found')
        );
    }
?>