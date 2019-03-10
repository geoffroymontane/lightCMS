<?php

if(file_exists("credentials.php")){
	include("credentials.php");
	$DBconnect = "mysql:dbname=".$DBName.";host=".$DBhost;
	$pdo = new PDO($DBconnect, $DBowner, $DBpw);
}
else{
	header("Location:install");
}

?>
