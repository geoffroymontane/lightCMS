<?php
	session_start();
	if(!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"]!=1){
		header("Location:connection.php");
		exit();
	}

?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link href="fonts/fonts.css" rel="stylesheet" type="text/css">
		<link href="global.css" rel="stylesheet" type="text/css">
		<link href="index.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script src="index.js"></script>
	</head>

	<body>

		<div id="topbar">
			<a id="topbarMenu" onclick="toggleShowMenu()">
				<i class="fas fa-bars"></i>
			</a>
		</div>
		<div id="menu">
			<a class="menuItem" onclick='goTo("contents.php")'>
				<i class="fas fa-edit"></i>
				<span class="menuItemText">Editeur</span>
			</a>
			<a class="menuItem" onclick='goTo("images.php")'>
				<i class="fas fa-images"></i>
				<span class="menuItemText">Images</span>
			</a>
			<a class="menuItem">
				<i class="fas fa-chart-bar"></i>
				<span class="menuItemText">Statistiques</span>
			</a>
			<a class="menuItem menuItemEnd" href="connection.php?disconnect">
				<i class="fas fa-sign-out-alt"></i>
				<span class="menuItemText">Déconnexion</span>
			</a>
		</div>
		
		<iframe src="editor.html" id="content"></iframe>
	</body>


</html>

