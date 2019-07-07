<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    session_start();

    $data = json_decode(file_get_contents("php://input"));

    if (isset($_SESSION['user'])){
        extract($_SESSION['user']);
        if ($data != ""){
            if ($user_type != $data->page_access){
                if ($user_type == 'Admin'){
                    echo json_encode(
                        array('url' => '/admin/dashboard')
                    );
                }
                else if ($user_type == 'Bursary Admin'){
                    echo json_encode(
                        array('url' => '/bursary/dashboard')
                    );
                }
                else if ($user_type == 'Counselor'){
                    echo json_encode(
                        array('url' => 'counselor/dashboard')
                    );
                }
                else{
                    echo json_encode(
                        array('url' => '/login')
                    );  
                }
            }

        }
        else{
            if ($user_type == 'Admin'){
                echo json_encode(
                    array('url' => '/admin/dashboard')
                );
            }
            else if ($user_type == 'Bursary Admin'){
                echo json_encode(
                    array('url' => '/bursary/dashboard')
                );
            }
            else if ($user_type == 'Counselor'){
                echo json_encode(
                    array('url' => '/counselor/dashboard')
                );
            }
        }
        
    }
?>