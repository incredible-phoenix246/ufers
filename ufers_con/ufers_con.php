<?php
$dsn = "mysql:host=mysql_db;dbname=ufers";
$user = "root";
$pass = "your_mysql_root_password";

try {
    $mycon = new PDO($dsn, $user, $pass);
    $mycon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>
