<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    session_start();

    $data = json_decode(file_get_contents("php://input"));

    //pages
    $admin_page = 'main.admin-dashboard';
    $counselor_page[] = 'main.counselor-dashboard';
    $counselor_page[] = 'main.cases';
    $counselor_page[] = 'main.reports';
    $counselor_page1 = 'main.counselor-dashboard';
    $counselor_page2 = 'main.cases';
    $counselor_page3 = 'main.reports';
    $bursary_page = 'main.bursary-dashboard';
    $login_page = 'login';
    $permission_denied_page = 'main.permission-denied';
    
    if (isset($_SESSION['user'])){
        extract($_SESSION['user']);
        $current_page = $data->current_page;
        if ($user_type == 'Admin'){
            if ($current_page != $admin_page){
                echo json_encode(
                    array('url' => $permission_denied_page)
                );
            }
            else{
                echo json_encode(
                    array('url' => '')
                );
            }
        }
        else if ($user_type == 'Bursary Admin'){
            if ($current_page != $bursary_page){
                echo json_encode(
                    array('url' => $permission_denied_page)
                );
            }
            else{
                echo json_encode(
                    array('url' => '')
                );
            }
        }
        else if ($user_type == 'Counselor'){

            $granted = false;

            foreach($counselor_page as $page){
                if ($current_page == $page){
                    $granted = true;
                }
            }

            if ($granted){
                echo json_encode(
                    array('url' => '')
                );  
            }
            else{
                echo json_encode(
                    array('url' => $permission_denied_page)
                );  
            }
        }
        
    }
    else{
        echo json_encode(
            array('url' => 'login')
        );  
    }
?>