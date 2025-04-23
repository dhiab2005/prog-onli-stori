<?php
$host = 'localhost';
$db   = 'dhiab';
$user = 'root';
$pass = '';


$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}


$conn->set_charset("utf8");
?>