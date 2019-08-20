<?php

date_default_timezone_set("Asia/Kuala_Lumpur");
$target_dir = "uploads/";

$file_name = "SEMMS_" . strtoupper(date("Ymd_His")) . ".jpeg";
$target_file = $target_dir . $file_name;
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
	echo json_encode(
            array('image_path' => $target_file), JSON_UNESCAPED_SLASHES
        );
}
else{
    echo json_encode(
        array('image_path' => "")
    );
}

?>