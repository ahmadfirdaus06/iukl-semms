<?php
    require("../../lib/rb.php");

    $host = '192.168.1.139';
   //   private $host = 'localhost';
    $db_name = 'iukl_semms';
    $username = 'root';
    $password = '';
    $conn;

    R::setup('mysql:host=' . $host . ';dbname=' . $db_name, $username, $password);
?>
