<?php

	include('database.php');
	session_start();
	sleep(1);

	if(isset($_POST['email']) && isset($_POST['password'])){

		$query=$pdo->prepare("SELECT * FROM lightcms_users WHERE email=?");
		$query->execute(array($_POST['email']));
		$tab=$query->fetchAll();
		
		if(password_verify($_POST['password'],$tab[0]["password"])){
			$_SESSION["isConnected"]=1;	
			$_SESSION["email"]=$_POST["email"];	
			header("Location: index.php");
			exit();
		}
		else{
			$_SESSION["isConnected"]=0;	
		}
	}
?>

<html>

	<head>
		
		<meta charset="UTF-8"/>
		<link href="fonts/fonts.css" rel="stylesheet" type="text/css">
		<link href="global.css" rel="stylesheet" type="text/css">
		<link href="connection.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script>
			function submit(){
				document.getElementById('connectionForm').submit();
			}	
		</script>
	</head>

	<body id="connectionBody">

		<div id="connectionContent">
			<form action='connection.php' method='post' id='connectionForm'>

				<div class='connectionFormInput'>
					<label>Email</label>
					<input type="email" name="email"/>
				</div>
				<div class='connectionFormInput'>
					<label>Mot de passe</label>
					<input type="password" name="password"/>
				</div>

				<div id='submit' class='button' onclick="submit();">
				Connexion
				</div>

			</form>
			
			<?php
			if(isset($_SESSION["isConnected"]) && $_SESSION["isConnected"]!=1){
				echo "
				<div id='connectionMsg'>
					<span id='connectionMsgText'>Erreur d'identification</span>
				</div>";
			}
			?>
		</div>
	</body>


</html>
