<?php

date_default_timezone_set("Asia/Kuala_Lumpur");
$target_dir = "../../../../semms-uploads/";
$temp_file = basename($_FILES["file"]["name"]);
$file_type = pathinfo($temp_file,PATHINFO_EXTENSION);
$uniquesavename = time().uniqid(rand());
$file_name = "SEMMS_" . strtoupper(date("Ymd_His_") . $uniquesavename)  . "." .$file_type;
$target_file = $target_dir . $file_name;
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
	echo json_encode(
            array('image_path' => $target_file), JSON_UNESCAPED_SLASHES
        );
}

?>