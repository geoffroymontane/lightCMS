<?php
//config SQL
$DBhost  = "localhost";
$DBowner = "root";
$DBpw    = "password";
$DBName  = "lightCMS";

$DBconnect = "mysql:dbname=".$DBName.";host=".$DBhost;
$pdo = new PDO($DBconnect, $DBowner, $DBpw);

?>
