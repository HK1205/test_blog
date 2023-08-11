<?php
session_start(); 
mb_internal_encoding("utf8");

$pdo = new PDO("mysql:dbname=lesson01;host=localhost;","root","");
$pdo->exec("insert into diworks_keijiban (handlename, title, comments) values ('".$_SESSION['handlename']."','".$_SESSION['title']."','".$_SESSION['comments']."');");
header("Location: http://localhost/diworks_keijiban/index.php");
exit;

    
?>