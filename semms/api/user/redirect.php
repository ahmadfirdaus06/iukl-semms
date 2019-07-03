<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    session_start();
    if (isset($_SESSION['user'])){
        if (isset($_GET['page_access'])){
            echo json_encode($_GET['page_access']);
            // extract($_SESSION['user']);
            // if ($user_type != $_GET['page_access']){
            //     if ($user_type == 'Admin'){
            //         echo json_encode(
            //             array('url' => 'aasasdmin/dashboard')
            //         );
            //     }
            //     else if ($user_type == 'Bursary Admin'){
            //         echo json_encode(
            //             array('url' => 'bursary/dashboard')
            //         );
            //     }
            //     else if ($user_type == 'Counselor'){
            //         echo json_encode(
            //             array('url' => 'counselor/dashboard')
            //         );
            //     }
            // }

        }
        else{
            extract($_SESSION['user']);

            if ($user_type == 'Admin'){
                echo json_encode(
                    array('url' => 'admin/dashboard')
                );
            }
            else if ($user_type == 'Bursary Admin'){
                echo json_encode(
                    array('url' => 'bursary/dashboard')
                );
            }
            else if ($user_type == 'Counselor'){
                echo json_encode(
                    array('url' => 'counselor/dashboard')
                );
            }
        }
        
    }
?>