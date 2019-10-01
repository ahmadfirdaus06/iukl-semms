<?php
    require("../../lib/rb.php");

    // $host = '192.168.1.139';
    // $host = 'localhost';
    $host = 'semms.ddns.net';
    $port = "49152";
    $db_name = 'iukl_semms';
    $username = 'root';
    $password = '';
    $conn;

    R::setup('mysql:host=' . gethostbyname($host) . ';port=' . $port . ';dbname=' . $db_name, $username, $password);
    // R::setup('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $db_name, $username, $password);
?>
